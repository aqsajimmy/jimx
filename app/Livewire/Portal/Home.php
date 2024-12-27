<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use Livewire\Attributes\Title;

class Home extends Component
{
    public $title = 'HØme';
    #[Title('HØme')]
    public function render()
    {
        return view('livewire.portal.home');
    }
}
