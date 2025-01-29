<div class="card shadow-lg">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        @if($type == "ventes")
            <h3 class="card-title m-0">Liste des Factures des VENTES</h3>
        @else
            <h3 class="card-title m-0">Liste des Factures des INSTALLATIONS</h3>
        @endif

        @if($type == "ventes")
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary  active" wire:click="Ventes()">VENTES</button>
                <button type="button" class="btn btn-secondary" wire:click="Intallations()" >INSTALLATIONS</button>
            </div>
        @else
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-secondary  " wire:click="Ventes()">VENTES</button>
                <button type="button" class="btn btn-secondary active" wire:click="Intallations()" >INSTALLATIONS</button>
            </div>
        @endif

    </div>
    <!-- /.card-header -->

    <div class="card-body p-0">
        <table class="table table-hover table-bordered table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Numéro de la Facture</th>
                    <th>Date</th>
                    <th>Nom du Client</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factures as $facture)
                    <tr>
                        <td class="fw-bold">{{ $facture->numeroFacture }}</td>
                        @if($type == "ventes")
                            <td>{{ $facture->ventes->created_at->format('d/m/Y') }}</td>
                            <td>{{ $facture->ventes->nomClient }}</td>
                            <td class="text-center">
                                <a href="{{ route('factures.ventes.telecharger', $facture->id) }}" class="btn btn-outline-success btn-sm" title="Télécharger">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('factures.ventes.afficher', $facture->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Afficher">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        @elseif($type == "installations")
                            <td>{{ $facture->installations->created_at->format('d/m/Y') }}</td>
                            <td>{{ $facture->installations->nomClient }}</td>
                            <td class="text-center">
                                <a href="{{ route('factures.installations.telecharger', $facture->id) }}" class="btn btn-outline-success btn-sm" title="Télécharger">
                                    <i class="bi bi-download"></i>
                                </a>
                                <a href="{{ route('factures.installations.afficher', $facture->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Afficher">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->


</div>
