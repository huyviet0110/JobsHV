<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Post extends Component
{
    public object $post;
    public string $languages;

    public function __construct($post)
    {
        $this->post = $post;
        $this->languages = implode(', ', $this->post->languages->pluck('name')->toArray());
    }

    public function render()
    {
        return view('components.post');
    }
}
