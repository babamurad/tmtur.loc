<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;
use Illuminate\Validation\Rule;

class CustomerEditComponent extends Component
{
    public $customer_id;
    public $full_name;
    public $email;
    public $phone;
    public $passport;
    public $gdpr_consent_at;

    public function mount($id)
    {
        $customer = Customer::findOrFail($id);
        $this->customer_id = $customer->id;
        $this->full_name = $customer->full_name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->passport = $customer->passport;
        $this->gdpr_consent_at = $customer->gdpr_consent_at ? \Carbon\Carbon::parse($customer->gdpr_consent_at)->format('Y-m-d') : null;
    }

    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($this->customer_id),
            ],
            'phone' => 'nullable|string|max:50',
            'passport' => 'nullable|string|max:50',
            'gdpr_consent_at' => 'nullable|date',
        ];
    }

    protected function messages()
    {
        return [
            'full_name.required' => 'Введите ФИО клиента.',
            'email.email' => 'Введите корректный Email.',
            'email.unique' => 'Такой Email уже существует.',
        ];
    }

    public function save()
    {
        $this->validate();

        $customer = Customer::findOrFail($this->customer_id);
        $customer->update([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'passport' => $this->passport,
            'gdpr_consent_at' => $this->gdpr_consent_at ? $this->gdpr_consent_at : null,
        ]);

        session()->flash('saved', [
            'title' => 'Клиент обновлен!',
            'text' => 'Данные клиента успешно сохранены.',
        ]);

        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.customers.customer-edit-component');
    }
}