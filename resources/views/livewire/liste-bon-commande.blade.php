<div class="table-responsive p-0 ">
    <table class="table table-hover align-items-center">
        <thead >
            <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Titre / Compte</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Montant</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dates</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Statut</th>
                <th class="text-secondary opacity-7">Action</th> <!-- Colonne pour les actions -->
            </tr>
        </thead>
        <tbody class="mb-5">
            @forelse($bonCommandes as $bonCommande)
            <tr>
                <!-- Titre et Compte -->
                <td>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $bonCommande->titre }}</h6>
                        <p class="text-xs text-secondary mb-0">{{ $bonCommande->comptes->nom }}</p>
                    </div>
                </td>
                <!-- Montant -->
                <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold">{{ number_format($bonCommande->montant, 0, ',', ' ') }} FCFA</span>
                </td>
                <!-- Dates -->
                <td class="align-middle text-center">
                    <p class="text-xs font-weight-bold mb-0">Commande: {{ \Carbon\Carbon::parse($bonCommande->date_commande)->format('d/m/Y') }}</p>
                    <p class="text-xs text-secondary mb-0">Livraison prévu: {{ \Carbon\Carbon::parse($bonCommande->date_livraison)->format('d/m/Y') }}</p>
                </td>
                <!-- Statut avec badge de couleur -->
                <td class="align-middle text-center text-sm">
                    @php
                        $badgeClass = '';
                        switch(strtolower($bonCommande->status)) {
                            case 'livré':
                                $badgeClass = 'bg-gradient-success';
                                break;
                            case 'en attente':
                                $badgeClass = 'bg-gradient-warning';
                                break;
                            case 'annulé':
                                $badgeClass = 'bg-gradient-danger';
                                break;
                            default:
                                $badgeClass = 'bg-gradient-secondary';
                        }
                    @endphp
                    <span class="badge badge-sm {{ $badgeClass }}"> {{$bonCommande->status}} </span>
                </td>
                <!-- Actions -->
                <td class="align-middle">
                    <!--voir les detail-->
                    <div class="d-flex justify-content-end">
                        <span type="button" title="voir les details de la bonCommande"  type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#voirDetail-{{ $bonCommande->id }}">
                            <i class="bi bi-eye"></i>
                        </span>
                        <!-- Modal pour afficher les detail de chaque bonCommande -->
                        <div class="modal fade" id="voirDetail-{{ $bonCommande->id }}" tabindex="-1" aria-labelledby="detail" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <livewire:modal-voir-bon-commande :bonCommande="$bonCommande">
                            </div>
                        </div>
                        @if($bonCommande->status !== 'livré')
                            <span type="button" title="modifier la bonCommande"  type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDetail-{{ $bonCommande->id }}">
                                <i class="bi bi-pencil"></i>
                            </span>
                        @endif
                        <!-- Modal pour modifier les detail de chaque bonCommande -->
                        <div class="modal fade" id="editDetail-{{ $bonCommande->id }}" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <livewire:modal-edit-bon-commande :bonCommande="$bonCommande">
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    <p class="mb-0">Aucun bon de commande trouvé.</p>
                    <a href="{{ route('bonCommandes.create') }}" class="btn btn-primary btn-sm mt-2">Créer le premier bon</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>