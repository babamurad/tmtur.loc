<?php

namespace App\Livewire;

use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use App\Models\ContactInfo;
use Livewire\WithPagination;

class ContactInfosCrud extends Component
{
    use WithPagination;
    public $label, $type, $value, $icon, $is_active = 1, $sort_order = 0, $input_type, $url, $editId = null;
    public $delId = null;
    protected $rules = [
        'label' => 'required|string',
        'type' => 'required|string',
        'value' => 'nullable|string',
        'icon' => 'nullable|string',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'input_type' => 'nullable|string',
        'url' => 'nullable|url',
    ];

    protected $listeners = ['editContact'];

    public function render()
    {
        $items = ContactInfo::orderBy('sort_order')->paginate(10);
        return view('livewire.contact-infos-crud', compact('items'));
    }

    public function resetForm()
    {
        $this->reset(['label','type','value','icon','is_active','sort_order','input_type','url','editId']);
        $this->is_active = 1; $this->sort_order = 0;
    }

    public function store()
    {
        $this->validate();
        if ($this->editId) {
            ContactInfo::find($this->editId)->update($this->onlyFillable());
        } else {
            ContactInfo::create($this->onlyFillable());
        }
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
}
