<?php

namespace App\Livewire\Front;

use App\Models\Tag;
use App\Models\TourCategory;
use Livewire\Component;
use Livewire\WithPagination;

class TagShowTour extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public Tag $tag;
    public string $view = 'grid';

    public function setView(string $view)
    {
        $this->view = $view;
        session()->put('tour_view_preference', $view);
    }

    public function mount($id)
    {
        $this->view = session('tour_view_preference', 'grid');
        $this->tag = Tag::with('tours')->findOrFail($id);
    }

    public function render()
    {
        $categories = TourCategory::where('is_published', true)->get();

        $tours = $this->tag->tours()
            ->where('is_published', true)
            ->with(['media', 'groupsOpen'])
            ->paginate(4);

        $tagName = $this->tag->tr('name');
        \Artesaos\SEOTools\Facades\SEOTools::setTitle($tagName);
        \Artesaos\SEOTools\Facades\SEOTools::setDescription("Tours with tag: $tagName");
        // \Artesaos\SEOTools\Facades\SEOTools::opengraph()->setUrl(route('tours.tag.show', $this->tag->id));

        return view('livewire.front.tag-show-tour', [
            'categories' => $categories,
            'tag' => $this->tag,
            'tours' => $tours,
            'view' => $this->view,
        ])
            ->layout('layouts.front-app', ['hideCarousel' => true]);
    }
}
