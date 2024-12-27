<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Blogs extends Component
{
    use WithPagination;
    public $title = 'BlØgs';
    public $search;
    public $pp = 6;
    #[Title('BlØgs')]
    public function render()
    {
        $collection = \App\Models\Article::with('category')->where('is_published', true)->paginate($this->pp);
        return view('livewire.portal.blogs', compact('collection'));
    }
}
