<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class CustomerCreateComponent extends Component
{
    public $full_name;
    public $email;
    public $phone;
    public $passport;
    public $gdpr_consent_at;

    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:customers,email',
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

        Customer::create([
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'passport' => $this->passport,
            'gdpr_consent_at' => $this->gdpr_consent_at ? $this->gdpr_consent_at : null,
        ]);

        session()->flash('saved', [
            'title' => 'Клиент создан!',
            'text' => 'Новый клиент успешно добавлен.',
        ]);

        return redirect()->route('customers.index');
    }

    public function render()
    {
        return view('livewire.customers.customer-create-component');
    }
}