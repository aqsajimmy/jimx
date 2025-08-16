<?php

namespace App\Livewire\Portal;

use App\Models\Template;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class WebsiteTemplates extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';
    public $title = 'Wèbsite Templatès';
    public $search;
    public $pp = 6;
    public bool $readyToLoad = false;
    
    #[Title('Wèbsite Templatès')]

    function loadTemplates()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.portal.website-templates', [
            'collections' => $this->readyToLoad
                ? Template::latest()->paginate(6)
                : collect(),
        ]);
    }
    
}
