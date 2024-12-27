<?php

namespace App\Livewire\Portal;

use Livewire\Component;
use Livewire\Attributes\Title;

class Contact extends Component
{
    public $title = 'CØntact';
    #[Title('CØntact')]
    public function render()
    {
        return view('livewire.portal.contact');
    }
}
