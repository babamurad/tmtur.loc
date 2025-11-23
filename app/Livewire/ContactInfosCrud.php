<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use App\Models\ContactInfo;
use Livewire\WithPagination;
use App\Support\SocialIcons;

class ContactInfosCrud extends Component
{
    use WithPagination;
    public $label, $type, $value, $icon, $is_active = 1, $sort_order = 0, $input_type, $url, $editId = null;
    public $delId = null;
    public $activeTab;
    public $trans = [];
    protected function rules()
    {
        $rules = [
            'label' => 'nullable|string', // теперь берется из trans
            'type' => 'required|string',
            'value' => 'nullable|string', // теперь берется из trans
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'input_type' => 'nullable|string',
            'url' => 'nullable|url',
        ];

        foreach (config('app.available_locales') as $l) {
            $rules["trans.$l.label"] = 'nullable|string|max:255';
            $rules["trans.$l.value"] = 'nullable|string';
        }

        return $rules;
    }

    protected $listeners = ['editContact'];

    public function render()
    {
        $items = ContactInfo::orderBy('sort_order')->paginate(10);
        $icons = SocialIcons::all();
        return view('livewire.contact-infos-crud', compact('items', 'icons'));
    }

    public function resetForm()
    {
        $this->reset(['label','type','value','icon','is_active','sort_order','input_type','url','editId', 'trans']);
        $this->is_active = 1; $this->sort_order = 0;
        $this->initTrans();
    }

    public function initTrans()
    {
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale] = [
                'label' => '',
                'value' => '',
            ];
        }
    }

    public function store()
    {
        // Заполняем основные поля из fallback локали
        $fallback = config('app.fallback_locale');
        $this->label = $this->trans[$fallback]['label'] ?? '';
        $this->value = $this->trans[$fallback]['value'] ?? '';

        $this->validate();

        if ($this->editId) {
            $item = ContactInfo::find($this->editId);
            $item->update($this->onlyFillable());
        } else {
            $item = ContactInfo::create($this->onlyFillable());
        }

        // Сохраняем переводы
        foreach ($this->trans as $locale => $fields) {
            foreach ($fields as $field => $value) {
                $item->setTr($field, $locale, $value);
            }
        }
        $item->flushTrCache();

        $this->resetForm();

        LivewireAlert::title('Info saved')
            ->text('Data has been successfully saved!')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function editContact($id)
    {
        $item = ContactInfo::findOrFail($id);
        $this->editId = $item->id;
        $this->label = $item->label;
        $this->type = $item->type;
        $this->value = $item->value;
        $this->icon = $item->icon;
        $this->is_active = $item->is_active;
        $this->sort_order = $item->sort_order;
        $this->input_type = $item->input_type;
        $this->url = $item->url;

        // Загружаем переводы
        foreach (config('app.available_locales') as $locale) {
            $this->trans[$locale]['label'] = $item->tr('label', $locale);
            $this->trans[$locale]['value'] = $item->tr('value', $locale);
        }
    }

    public function delete($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить?')
            ->text('Вы уверены, что хотите удалить информацию?')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('deleteConfirm')
            ->show(null, ['backdrop' => true]);

    }

    public function deleteConfirm()
    {
        ContactInfo::findOrFail($this->delId)->delete();
        LivewireAlert::title('Информация удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    protected function onlyFillable()
    {
        return [
            'label' => $this->label,
            'type' => $this->type,
            'value' => $this->value,
            'icon' => $this->icon,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'input_type' => $this->input_type,
            'url' => $this->url,
        ];
    }

    public function selectActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function mount()
    {
        $this->activeTab = 'contact-tab';
        $this->initTrans();
    }
}
