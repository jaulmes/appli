<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;

class ModalVoirActiviteClient extends Component
{
    public $client;

    public function mount($client)
    {
        $this->client = Client::find($client->id);
    }

    public function render()
    {
        return view('livewire.modal-voir-activite-client');
    }
}
