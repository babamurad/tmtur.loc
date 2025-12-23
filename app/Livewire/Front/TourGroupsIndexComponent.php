<?php

namespace App\Livewire\Front;

use App\Models\TourGroup;
use App\Models\ContactMessage;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Artesaos\SEOTools\Facades\SEOTools;

class TourGroupsIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $layout = 'layouts.front-app';
    public array $layoutData = ['hideCarousel' => true];
    public string $title = 'titles.tours';

    // Фильтры
    #[Url(except: '')]
    public ?string $month = null;

    #[Url(except: '')]
    public ?string $year = null;
    public int $perPage = 9;

    // Модальное окно бронирования
    public bool $showBookingModal = false;
    public ?TourGroup $selectedGroup = null;

    // Поля формы в модальном окне
    public string $booking_name = '';
    public string $booking_email = '';
    public string $booking_phone = '';
    public string $booking_guests = '1';
    public string $booking_message = '';
    public bool $gdpr_consent = false;

    protected function rules(): array
    {
        return [
            'booking_name' => ['required', 'string', 'max:255'],
            'booking_email' => ['required', 'email', 'max:255'],
            'booking_phone' => ['nullable', 'string', 'max:50'],
            'booking_guests' => ['required', 'integer', 'min:1'],
            'booking_message' => ['nullable', 'string', 'max:2000'],
            'gdpr_consent' => ['accepted'],
        ];
    }

    public function mount(): void
    {
        // if (is_null($this->month)) {
        //     $this->month = (string) now()->month;
        // }

        // if (is_null($this->year)) {
        //     $this->year = (string) now()->year;
        // }
    }

    public function updatingMonth(): void
    {
        $this->resetPage();
    }

    public function updatingYear(): void
    {
        $this->resetPage();
    }

    // Открытие модального окна с выбранной группой
    public function openBookingModal(int $groupId): void
    {
        $this->selectedGroup = TourGroup::with('tour')->findOrFail($groupId);
        $this->resetBookingForm(clearContactData: false);
        $this->showBookingModal = true;
    }

    public function closeBookingModal(): void
    {
        $this->showBookingModal = false;
    }

    /**
     * Сброс полей формы.
     *
     * @param bool $clearContactData если true — очистим ещё имя/email/телефон
     */
    public function resetBookingForm(bool $clearContactData = false): void
    {
        if ($clearContactData) {
            $this->booking_name = '';
            $this->booking_email = '';
            $this->booking_phone = '';
        }

        $this->booking_guests = '1';
        $this->booking_message = '';
        $this->gdpr_consent = false;

        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function submitBooking(): void
    {
        if (!$this->selectedGroup) {
            $this->addError('booking_general', __('messages.no_tour_group_selected'));
            return;
        }

        $validated = $this->validate();

        $available = (int) $this->selectedGroup->freePlaces();
        $guests = (int) $validated['booking_guests'];

        if ($available <= 0 || $guests > max($available, 0)) {
            $this->addError('booking_guests', __('messages.not_enough_free_places'));
            return;
        }

        $tourTitle = $this->selectedGroup->tour?->tr('title')
            ?? $this->selectedGroup->tour?->title
            ?? '';
        $startDate = $this->selectedGroup->starts_at
            ? \Carbon\Carbon::parse($this->selectedGroup->starts_at)->format('d.m.Y')
            : '';

        // Текст сообщения, в котором есть ВСЯ информация по туру и клиенту
        $messageBody = "Новая заявка на групповую дату тура.\n\n"
            . "Тур: {$tourTitle}\n"
            . "Дата выезда: {$startDate}\n"
            . "ID группы: {$this->selectedGroup->id}\n"
            . "Количество гостей: {$guests}\n\n"
            . "Имя клиента: {$validated['booking_name']}\n"
            . "Email: {$validated['booking_email']}\n"
            . "Телефон: {$validated['booking_phone']}\n\n"
            . "Сообщение клиента:\n"
            . ($validated['booking_message'] ?: '-');

        // Сохраняем в contact_messages
        // ВАЖНО: подстрой поля под свою модель ContactMessage (если структура другая)
        ContactMessage::create([
            'name' => $validated['booking_name'],
            'email' => $validated['booking_email'],
            'phone' => $validated['booking_phone'],
            'message' => $messageBody,
        ]);

        // Сохраняем или обновляем клиента
        Customer::updateOrCreate(
            ['email' => $validated['booking_email']],
            [
                'full_name' => $validated['booking_name'],
                'phone' => $validated['booking_phone'],
                'gdpr_consent_at' => now(),
            ]
        );

        // Отправляем email админу (на почту из config/mail.php)
        $adminEmail = config('mail.from.address');

        if ($adminEmail) {
            Mail::raw($messageBody, function ($message) use ($adminEmail) {
                $message->to($adminEmail)
                    ->subject('Новая заявка на групповую дату тура');
            });
        }

        $this->showBookingModal = false;
        $this->resetBookingForm();

        session()->flash('success', __('messages.booking_request_sent_successfully'));
    }

    public function render()
    {
        SEOTools::setTitle(__($this->title) ?? 'Тур Группы');
        SEOTools::setDescription('Расписание групповых туров по Туркменистану. Присоединяйтесь к нам!');
        SEOTools::opengraph()->setUrl(route('front.tour-groups'));

        $groups = TourGroup::with('tour')
            ->when($this->month, function ($query) {
                $query->whereMonth('starts_at', $this->month);
            })
            ->when($this->year, function ($query) {
                $query->whereYear('starts_at', $this->year);
            })
            ->orderBy('starts_at')
            ->paginate($this->perPage);

        return view('livewire.front.tour-groups-index', [
            'groups' => $groups,
            'months' => $this->getMonths(),
            'years' => $this->getYears(),
        ])
            ->layout($this->layout, $this->layoutData);
    }

    private function getMonths(): array
    {
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = __('months.' . $i);
        }

        return [null => __('Все месяцы')] + $months;
    }

    private function getYears(): array
    {
        $currentYear = now()->year;
        $years = [];

        for ($i = $currentYear - 2; $i <= $currentYear + 5; $i++) {
            $years[$i] = $i;
        }

        return [null => __('Все годы')] + $years;
    }
}
