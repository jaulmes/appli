<?php

namespace App\Livewire;

use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;

class TransactionMensuel extends Component
{
    public $moisSelectionne;

    public function mount()
    {
        $this->moisSelectionne = now()->format('Y-m'); // mois actuel par défaut
    }

    public function getTransactionsProperty()
    {
        return Transaction::whereYear('created_at', Carbon::parse($this->moisSelectionne)->year)
                          ->whereMonth('created_at', Carbon::parse($this->moisSelectionne)->month)
                          ->latest()
                          ->get();
    }
    public function render()
    {
        return view('livewire.transaction-mensuel', [
            'transactions' => $this->transactions,
        ]);
    }
}
