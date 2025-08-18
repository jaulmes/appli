@extends('dashboard.main')

@section('content')
<section class="h-100 h-custom">
    <div class="container h-100 py-4">

        {{-- Toolbar: actions et recherche --}}
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-3">
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('dashboard.compte.create') }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un moyen de paiement
                </a>
            </div>
            <a href="{{ route('dashboard.compte.transfert') }}" class="d-flex gap-2 align-items-center btn btn-dark btn-sm">
                <i class="bi bi-arrow-left-right me-1"></i> Faire un transfert
            </a>

        </div>

        {{-- Messages flash --}}
        <div class="row mb-3">
            <div class="col-12">
                @if(session('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('erreur'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('erreur') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Résumé : nombre de comptes et total montant --}}
        @php
            $totalMontant = collect($comptes)->sum('montant');
            $nbComptes = is_countable($comptes) ? count($comptes) : ( $comptes->total() ?? (is_iterable($comptes) ? iterator_count($comptes) : 0) );
        @endphp

        <div class="row g-3 mb-3">
            <div class="col-12 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Nombre de comptes</small>
                            <h4 class="mb-0">{{ $nbComptes }}</h4>
                        </div>
                        <div><i class="bi bi-people-fill fs-2 text-secondary"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Montant total</small>
                            <h4 class="mb-0">
                                <span class="badge bg-warning text-dark">
                                    {{ number_format($totalMontant ?? 0, 0, ',', ' ') }}
                                </span>
                                <small class="text-muted ms-2">FCFA</small>
                            </h4>
                        </div>
                        <div><i class="bi bi-wallet2 fs-2 text-success"></i></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid des comptes --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @forelse ($comptes as $compte)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1 fw-semibold">{{ $compte->nom }}</h6>
                                </div>

                                <div class="text-end">
                                    <span class="h6 mb-0 d-block text-success">
                                        {{ number_format($compte->montant ?? 0, 0, ',', ' ') }} <small class="text-muted">FCFA</small>
                                    </span>
                                </div>
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center gap-2">
                                <div class="d-flex gap-1">
                                    @can('MODIFIER_COMPTE')
                                        <a href="{{ route('dashboard.compte.edit', $compte->id) }}" class="btn btn-sm btn-outline-primary" title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endcan

                                    @can('SUPPRIMER_COMPTE')
                                        <!-- Bouton déclenchant le modal de suppression -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $compte->id }}" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endcan
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Modal suppression (unique par compte) --}}
                    @can('SUPPRIMER_COMPTE')
                        <div class="modal fade" id="deleteModal-{{ $compte->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $compte->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title" id="deleteModalLabel-{{ $compte->id }}">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        Voulez-vous vraiment supprimer le compte <strong>{{ $compte->nom }}</strong> ?
                                        <div class="mt-2 text-muted small">Cette action est irréversible.</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>

                                        <form action="{{ route('dashboard.compte.delete', $compte->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            @empty
                <div class="col">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <p class="mb-0 text-muted"><i class="bi bi-info-circle me-1"></i> Aucun compte trouvé.</p>
                            <a href="{{ route('dashboard.compte.create') }}" class="btn btn-sm btn-primary mt-3">Ajouter un compte</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination si disponible --}}
        <div class="mt-4">
            @if(method_exists($comptes, 'links'))
                {{ $comptes->links() }}
            @endif
        </div>
    </div>
</section>
@endsection


