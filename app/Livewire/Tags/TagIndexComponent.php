<?php

namespace App\Livewire\Tags;

use App\Models\Tag;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class TagIndexComponent extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public int $perPage = 10;
    public string $search = '';
    public $delId;

    // For inline editing (simple version) or we can redirect to edit page. 
    // Let's keep it simple: List & Delete for now, we can add Rename later if needed or via a modal.
    // Actually, let's allow basic renaming via a separate small Edit component or just here if simple. 
    // Given the project structure uses separate Edit components usually, I'll stick to Index for now and if needed add Edit later.
    // Wait, the user expects "manage". I should probably creating a simple TagEditComponent or handle it here. 
    // Let's add a simple edit modal or just redirect to an edit page. 
    // To match `CategoryIndexComponent` pattern: it redirects to `categories.edit`.
    // I will stick to Index first to show the list, as that's the main request "sidebar item". 

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function deleteConfirm($id)
    {
        $this->delId = $id;
        LivewireAlert::title('Удалить тег?')
            ->text('Вы уверены? Это удалит тег у всех туров.')
            ->timer(5000)
            ->withConfirmButton('Да')
            ->withCancelButton('Отмена')
            ->onConfirm('delete')
            ->show();
    }

    public function delete($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->delete();

        LivewireAlert::title('Тег удален.')
            ->success()
            ->toast()
            ->position('top-end')
            ->show();
    }

    public function render()
    {
        $tags = Tag::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderByDesc('id')
            ->paginate($this->perPage);

        return view('livewire.tags.tag-index-component', compact('tags'));
    }
}
