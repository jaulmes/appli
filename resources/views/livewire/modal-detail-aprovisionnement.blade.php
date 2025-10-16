<div class="modal fade" id="viewDetail-{{$achat->id}}" tabindex="-1" aria-labelledby="detailModalLabel-{{$achat->id}}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg">
            
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title d-flex align-items-center" id="detailModalLabel-{{$achat->id}}">
                    <i class="fas fa-receipt me-2"></i> Détails de l'achat #{{ $achat->id }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <div class="row g-4">
                    
                    <!-- Infos Commercial -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>Informations du Commercial</h6>
                                <p><strong>Nom :</strong> {{ $achat->user->name }}</p>
                                <p><strong>Téléphone :</strong> {{ $achat->user->numero }}</p>
                                <p><strong>Date :</strong> {{ $achat->created_at->format('d/m/Y H:i') }}</p>
                                <p><strong>Montant total :</strong> {{ number_format($achat->total, 0, ',', ' ') }} XAF</p>
                                <p><strong>Montant versé :</strong> {{ number_format($achat->montantVerse, 0, ',', ' ') }} XAF</p>
                                <p>
                                    <strong>Reste :</strong>
                                    @php $reste = $achat->total - $achat->montantVerse; @endphp
                                    @if($reste > 0)
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-hourglass-half me-1"></i>{{ number_format($reste, 0, ',', ' ') }} XAF
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Payé intégralement
                                        </span>
                                    @endif
                                </p>
                                <p>
                                    <strong>Statut :</strong>
                                    @if($reste > 0)
                                        <span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Non terminé</span>
                                    @else
                                        <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i> Terminé</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Produits -->
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-primary mb-3"><i class="fas fa-box me-2"></i>Produits inclus</h6>
                                <ul class="list-group list-group-flush">
                                    @foreach($achat->produits as $produit)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary me-2">{{ $produit->pivot->quantity }}</span>
                                                <strong>{{ $produit->name }}</strong> 
                                                <span class="text-muted">({{ number_format($produit->pivot->price, 0, ',', ' ') }} XAF)</span>
                                            </div>
                                            <div>
                                                @if ($produit->stock < 5)
                                                    <span class="badge bg-danger">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>{{ $produit->stock }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle me-1"></i>{{ $produit->stock }}
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Fermer
                </button>
                <button class="btn btn-primary" data-bs-target="#ModalAjouterPaiement-{{$achat->id}}"
                        data-bs-toggle="modal">
                    <i class="fas fa-plus-circle me-1"></i> Ajouter paiement
                </button>
            </div>
        </div>
    </div>
    <style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4e73df, #224abe);
}
.modal-content {
    border-radius: 12px;
}
.card {
    border-radius: 10px;
}
.list-group-item {
    border: none;
    border-bottom: 1px solid #f1f1f1;
}
</style>
</div>


