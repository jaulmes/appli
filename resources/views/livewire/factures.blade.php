<!-- Card principale -->
<div class="card shadow-lg">
    <!-- Entête de la carte -->
    <div class="card-header bg-primary text-white d-flex flex-column flex-sm-row justify-content-between align-items-center py-3 px-4">
        <h3 class="card-title m-0">
            @if($type == "ventes")
                Liste des Factures des VENTES
            @elseif($type == "proformat")
                Liste des Factures des PROFORMATS
            @elseif($type == "installations")
                Liste des Factures des INSTALLATIONS
            @endif
        </h3>

        <!-- Boutons de navigation -->
        <div class="btn-group mt-3 mt-sm-0" role="group">
            <button wire:key="facture-ventes" type="button" class="btn btn-outline-light @if($type == 'ventes') active @endif" wire:click="Ventes()">
                <i class="fas fa-chart-line"></i> VENTES
            </button>
            <button wire:key="facture-installations" type="button" class="btn btn-outline-light @if($type == 'installations') active @endif" wire:click="Installations()">
                <i class="fas fa-cogs"></i> INSTALLATIONS
            </button>
            <button wire:key="facture-proformat" type="button" class="btn btn-outline-light @if($type == 'proformat') active @endif" wire:click="Proformats()">
                <i class="fas fa-file-invoice"></i> PROFORMATS
            </button>   
        </div>
    </div>

    <!-- Corps de la carte -->
    <div class="card-body p-0">
        <!-- Message d'alerte -->
        @if (session()->has('message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {!! session('success') !!}
            </div>
        @endif

        <!-- Tableau des factures -->
        <div class="table-responsive">
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
                                <td>{{ $facture->ventes->created_at?->format('d/m/Y') ?? '-' }}</td>
                                <td style=" text-align: center;">{{ $facture->ventes->clients->nom?? $facture->ventes->nomClient?? $facture->ventes->commandes->clients->nom?? '-' }}</td>
                                <td class="text-center" id="facture-{{$facture->id}}">
                                    <a href="{{ route('factures.ventes.telecharger', $facture->id) }}" class="btn btn-outline-success btn-sm" title="Télécharger">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <a href="#" wire:click="exploiterFacture({{$facture->id}})" class="btn btn-outline-dark btn-sm" title="Exploiter">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                    <a href="{{ route('factures.ventes.afficher', $facture->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Afficher">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" wire:click="supprimerFacture({{$facture->id}})" class="btn btn-outline-danger btn-sm" title="Annuler" onclick="confirm('Voulez-vous supprimer cette facture ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            @elseif($type == "installations")
                                <td>{{ $facture->installations->created_at?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $facture->installations->nomClient ?? $facture->installations->clients->nom?? '-' }}</td>
                                <td class="text-center" id="facture-{{$facture->id}}">
                                    <a href="{{ route('factures.installations.telecharger', $facture->id) }}" class="btn btn-outline-success btn-sm" title="Télécharger">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    <a href="#" wire:click="exploiterFacture({{$facture->id}})" class="btn btn-outline-dark btn-sm" title="Exploiter">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                    <a href="{{ route('factures.installations.afficher', $facture->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Afficher">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#"  wire:click="supprimerFacture({{$facture->id}})" class="btn btn-outline-danger btn-sm" title="Annuler" onclick="confirm('Voulez-vous supprimer cette facture ?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            @elseif($type == "proformat")
                                <td>{{ $facture->proformats->created_at?->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $facture->proformats->clients->nom?? $facture->proformats->nomClient }}</td>
                                <td class="text-center" id="facture-{{$facture->id}}">
                                    <a href="{{ route('factures.proformats.afficher', $facture->id) }}" target="_blank" class="btn btn-outline-info btn-sm" title="Afficher">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" wire:click="exploiterFacture({{$facture->id}})" class="btn btn-outline-dark btn-sm" title="Exploiter">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--message success-->
</div>
