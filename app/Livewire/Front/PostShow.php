<?php

namespace App\Livewire\Front;

use App\Models\Post;
use Livewire\Component;

class PostShow extends Component
{
    public $post;

    public function mount($id)
    {
        $this->post = Post::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.front.post-show')->layout('layouts.front-app');
    }
}