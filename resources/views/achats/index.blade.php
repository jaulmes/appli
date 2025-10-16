@extends('dashboard.main')

@section('content')
<div class="container-xl px-4 mt-4">

    <!-- Toast message session -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100">
        @if (session()->has('message'))
        <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <!-- Card principale -->
    <div class="card shadow-lg border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0"><i class="fas fa-shopping-basket me-2"></i><strong>Liste des achats</strong></h3>

            <!-- Barre de recherche -->
            <form class="d-flex" style="max-width: 250px;">
                <input type="text" class="form-control form-control-sm me-2 shadow-sm" placeholder="Rechercher...">
                <button type="submit" class="btn btn-light btn-sm shadow-sm">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Table -->
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>Nom de l'auteur</th>
                            <th>Numéro</th>
                            <th>Quantité</th>
                            <th>Montant total</th>
                            <th>Montant restant</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($achats as $achat)
                        <tr>
                            <td class="fw-semibold">{{ $achat->user->name }}</td>
                            <td>{{ $achat->user->numero }}</td>
                            <td><span class="badge bg-info">{{ $achat->qte }}</span></td>
                            <td class="text-success fw-bold">{{ number_format($achat->total, 0, ',', ' ') }} FCFA</td>
                            <td class="text-danger fw-bold">{{ number_format($achat->total - $achat->montantVerse, 0, ',', ' ') }} FCFA</td>
                            <td>{{ \Carbon\Carbon::parse($achat->date)->format('d/m/Y') }}</td>
                            <td>
                                @if($achat->total > $achat->montantVerse)
                                    <span class="badge bg-danger">non terminé</span>
                                    
                                @else
                                    <span class="badge bg-warning text-dark">Validé</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="#"  class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#viewDetail-{{$achat->id}}" title="Voir"><i class="fas fa-eye"></i></a>

                                    <!-- Modal -->
                                    <livewire:modal-detail-aprovisionnement :achat="$achat" />
                                    <livewire:modal-add-paiement-achat :achat="$achat" />

                                    <!--modal supprimer achat avec raison-->
                                    <a href="#"  class="btn btn-sm btn-danger ml-3" data-bs-toggle="modal" data-bs-target="#deleteAprovisionement-{{$achat->id}}" title="supprimer"><i class="fas fa-trash-alt"></i></a>
                                    <livewire:modal-supprimer-aprovionnement :achat="$achat"/>

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Aucun achat trouvé
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Script pour activer les toasts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'))
        toastElList.map(function (toastEl) {
            new bootstrap.Toast(toastEl).show()
        })
    });
</script>
@endsection
