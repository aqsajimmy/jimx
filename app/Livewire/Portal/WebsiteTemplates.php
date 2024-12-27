<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class WebsiteTemplates extends Component
{
    use WithPagination;
    public $title = 'Wèbsite Templatès';
    public $search;
    public $pp = 6;
    #[Title('Wèbsite Templatès')]
    public function render()
    {
        $collection = \App\Models\Article::with('category')->where('is_published', true)->paginate($this->pp);
        return view('livewire.portal.website-templates', compact('collection'));
    }
}
