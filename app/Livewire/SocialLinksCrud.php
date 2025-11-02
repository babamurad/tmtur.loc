<?php

namespace App\Livewire;

use App\Models\SocialLink;
use App\Support\SocialIcons;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class SocialLinksCrud extends Component
{
    use WithPagination;

    /* поля формы */
    public $name, $url, $icon, $btn_class, $is_active = 1, $sort_order = 0, $editId = null, $delId = null;

    protected $rules = [
        'name'      => 'required|string|max:255',
        'url'       => 'required|url|max:255',
        'icon'      => 'nullable|string|max:255',
        'btn_class' => 'nullable|string|max:255',
        'is_active' => 'boolean',
        'sort_order'=> 'integer|min:0',
    ];

    public function render()
    {
        return view('livewire.social-links-crud', [
            'items' => SocialLink::orderBy('sort_order')->paginate(10),
            'icons' => SocialIcons::all(), // ключ → html
        ]);
    }

    public function resetForm()
    {
        $this->reset(['name','url','icon','btn_class','is_active','sort_order','editId']);
        $this->is_active  = 1;
        $this->sort_order = SocialLink::max('sort_order') + 1;
    }

    public function store()
    {
        $this->validate();

        $data = $this->only(['name','url','icon','btn_class','is_active','sort_order']);

        $this->editId
            ? SocialLink::find($this->editId)->update($data)
            : SocialLink::create($data);

        $this->resetForm();

        LivewireAlert::title('Saved')
            ->text('Social link saved!')
            ->success()->toast()->position('top-end')->show();
    }

    public function edit($id)
    {
        $sl = SocialLink::findOrFail($id);
        $this->editId   = $sl->id;
        $this->name     = $sl->name;
        $this->url      = $sl->url;
        $this->icon     = $sl->icon;
        $this->btn_class= $sl->btn_class;
        $this->is_active= $sl->is_active;
        $this->sort_order=$sl->sort_order;
    }

    public function delete($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Delete?')
            ->text('Sure to remove this link?')
            ->timer(5000)
            ->withConfirmButton('Yes')->withCancelButton('Cancel')
            ->onConfirm('deleteConfirmed')
            ->show(null, ['backdrop' => true]);
    }

    public function deleteConfirmed()
    {
        SocialLink::findOrFail($this->delId)->delete();
        LivewireAlert::title('Deleted')->success()->toast()->position('top-end')->show();
    }
}
