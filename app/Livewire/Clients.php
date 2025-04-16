<?php

namespace App\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{

    public $client;
    public $search = '';
    use WithPagination;

    public function mount()
    {
        //$this->clients = Client::paginate(10);
    }

    public function updatedSearch()
    {
        $this->client = Client::where('name', 'like', '%' . $this->search . '%')->get();
    }

    public function deleteClient($clientId)
    {
        $client = Client::find($clientId);
        if ($client) {
            $client->delete();
            $this->client = Client::all();
            session()->flash('message', 'Client deleted successfully.');
        } else {
            session()->flash('error', 'Client not found.');
        }
    }
    public function render()
    {
        return view('livewire.clients',
    [
        'clients' => Client::paginate(10),
    ]);
    }
}
