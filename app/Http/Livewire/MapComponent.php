<?php

namespace App\Http\Livewire;

use Livewire\Component;

class MapComponent extends Component
{
    public $latitude;
    public $longitude;
    public $zoom = 15;

    public function render()
    {
        return view('livewire.map');
    }


    public function mounted()
    {
        $this->dispatchBrowserEvent('initMap');
    }

    
}