<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use Livewire\Attributes\Title;

class About extends Component
{
    public $title = 'AbØut';
    #[Title('AbØut')]
    public function render()
    {
        return view('livewire.portal.about');
    }
}
