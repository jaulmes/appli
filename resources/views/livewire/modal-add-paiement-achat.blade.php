<div class="modal fade" style="font-size:small" wire:ignore.self id="ModalAjouterPaiement-{{$achat->id}}" aria-hidden="true" aria-labelledby="ModalAjouterPaiementLabel-{{$achat->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0">
            <!-- Formulaire de paiement -->
            <form wire:submit.prevent="ajouterPaiement">
                <!-- Header -->
                <div class="modal-header bg-gradient-success text-white">
                    <h5 class="modal-title d-flex align-items-center" id="ModalAjouterPaiementLabel-{{$achat->id}}">
                        <i class="fas fa-money-check-alt me-2"></i>
                        Ajouter un paiement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                
                <!-- Body avec scroll -->
                <div class="modal-body p-4">

                    <!-- Résumé de la commande -->
                    <div class="aler alert-info border-0 shadow-sm mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Achat #{{ $achat->id }}</strong>
                        </div>
                        <div class="row g-2 small">
                            <div class="col-6">
                                <span class="text-muted">Montant total:</span>
                                <div class="fw-bold text-dark">{{ number_format($achat->total, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="col-6">
                                <span class="text-muted">Déjà payé:</span>
                                <div class="fw-bold text-success">{{ number_format($achat->montantVerse, 0, ',', ' ') }} FCFA</div>
                            </div>
                            <div class="col-12 mt-2 pt-2 border-top">
                                <span class="text-muted">Reste à payer:</span>
                                <div class="fw-bold text-danger fs-5">{{ number_format($achat->total - $achat->montantVerse, 0, ',', ' ') }} FCFA</div>
                            </div>
                        </div>
                    </div>
                        <!-- Méthode de paiement -->
                        <div class="mb-4">
                            <!--message d'erreur-->
                            @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
                            </div>
                            @endif
                            <!--fin message d'erreur-->
                            <label for="paymentMethod-{{$achat->id}}" class="form-label fw-semibold">
                                <i class="fas fa-credit-card text-primary me-2"></i>
                                Méthode de paiement
                            </label>
                            <select class="form-select form-select-lg" id="paymentMethod-{{$achat->id}}" wire:model="modePaiement" required>
                                <option  selected>--Sélectionnez un compte--</option>
                                @foreach($comptes as $compte)
                                    <option value="{{ $compte->id }}">
                                        {{ $compte->nom }} - Solde: {{ number_format($compte->montant, 0, ',', ' ') }} FCFA
                                    </option>
                                @endforeach
                                <p>@error('modePaiement') {{$message}} @enderror</p>
                            </select>
                            <div class="form-text">
                                <i class="fas fa-lightbulb me-1"></i>
                                Choisissez le compte à débiter pour ce paiement
                            </div>
                        </div>

                        <!-- Montant -->
                        <div class="mb-4">
                            <label for="amount-{{$achat->id}}" class="form-label fw-semibold">
                                <i class="fas fa-dollar-sign text-success me-2"></i>
                                Montant à payer
                            </label>
                            <div class="input-group input-group-lg">
                                <input 
                                    type="number" 
                                    class="form-control" 
                                    wire:model="montantVerse" 
                                    max="{{ $achat->total - $achat->montantVerse }}"
                                    required 
                                    placeholder="Entrez le montant"
                                >
                                <span class="input-group-text bg-light">FCFA</span>
                                <p>@error('montantVerse') {{ $message}} @enderror</p>
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Montant maximum: <strong>{{ number_format($achat->total - $achat->montantVerse, 0, ',', ' ') }} FCFA</strong>
                            </div>
                        </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer bg-light border-top">
                    <button type="button" class="btn btn-secondary px-4" data-bs-target="#viewDetail-{{$achat->id}}" data-bs-toggle="modal">
                        <i class="fas fa-arrow-left me-2"></i>
                        Retour
                    </button>
                    <button 
                        type="submit" 
                        class="btn btn-success px-4"
                        wire:loading.attr="disabled"
                        wire:loading.class="disabled"
                    >
                        <span wire:loading.remove>
                            <i class="fas fa-check-circle me-2"></i>
                            Enregistrer le paiement
                        </span>
                        <span wire:loading>
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            Traitement...
                        </span>
                    </button>
                </div>
            </form>  
        </div>
    </div>

    <style>
    /* Gradient personnalisé */
    .bg-gradient-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }

    /* Modal */
    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    /* Modal body scroll */
    .modal-body {
        max-height: 60vh;
        overflow-y: auto;
        padding-right: 1rem;
    }

    .modal-body::-webkit-scrollbar {
        width: 6px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }

    /* Alert box */
    .aler {
        border-radius: 12px;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    /* Form controls */
    .form-select,
    .form-control {
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
    }

    .form-select:focus,
    .form-control:focus {
        border-color: #38ef7d;
        box-shadow: 0 0 0 0.2rem rgba(56, 239, 125, 0.15);
    }

    .input-group-text {
        border: 2px solid #e2e8f0;
        border-left: none;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }

    .input-group .form-control:focus + .input-group-text {
        border-color: #38ef7d;
        background-color: #e8f8f0;
    }

    /* Quick amount buttons */
    .quick-amount-btn {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .quick-amount-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .quick-amount-btn:active {
        transform: translateY(0);
    }

    /* Form labels */
    .form-label {
        margin-bottom: 0.75rem;
        color: #2d3748;
    }

    .form-text {
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    /* Buttons */
    .btn {
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 8px;
    }

    .btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        border: none;
    }

    .btn-success:hover:not(:disabled) {
        background: linear-gradient(135deg, #0f8276 0%, #2dd969 100%);
    }

    /* Loading state */
    .btn.disabled,
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Footer */
    .modal-footer {
        padding: 1rem 1.5rem;
    }

    /* Responsive */
    @media (max-width: 576px) {
        .quick-amount-btn {
            flex: 1 1 calc(50% - 0.5rem);
        }
    }
    </style>
</div>
