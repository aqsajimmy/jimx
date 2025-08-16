<?php

namespace App\Livewire\Portal;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class Blogs extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $title = 'BlØgs';
    public $search;
    public $pp = 6;
    public bool $readyToLoad = false;

    #[Title('BlØgs')]

    function loadBlogs()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.portal.blogs', [
            'articles' => $this->readyToLoad
                ? Article::latest()->paginate(6)
                : collect(),
        ]);
    }
}
