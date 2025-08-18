@extends('dashboard.main')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête de la page -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-dark font-weight-bold mb-1">
                        <i class="fas fa-exchange-alt text-primary me-2"></i>
                        Transfert entre Comptes
                    </h2>
                    <p class="text-muted mb-0">Transférez des fonds entre vos différents moyens de paiement</p>
                </div>
                <a href="{{ route('dashboard.compte') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Retour aux comptes
                </a>
            </div>
        </div>
    </div>

    <!-- Messages de notification -->
    <div class="row">
        <div class="col-12">
            @if(session('message'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>

    <!-- Formulaire de transfert -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white border-0 py-3">
                    <h5 class="mb-0 text-center">
                        <i class="fas fa-money-bill-transfer me-2"></i>
                        Effectuer un Transfert
                    </h5>
                </div>
                
                <div class="card-body p-5">
                    <form action="{{ route('dashboard.compte.valider_transfert') }}" method="post" id="transferForm">
                        @csrf
                        
                        <!-- Étapes du transfert -->
                        <div class="transfer-steps mb-4">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="step-indicator active" id="step1">
                                        <div class="step-number">1</div>
                                        <div class="step-label">Compte Source</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="step-indicator" id="step2">
                                        <div class="step-number">2</div>
                                        <div class="step-label">Montant</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="step-indicator" id="step3">
                                        <div class="step-number">3</div>
                                        <div class="step-label">Destination</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4">
                            <!-- Compte Envoyeur -->
                            <div class="col-lg-5">
                                <div class="transfer-card sender-card">
                                    <div class="card-header bg-danger bg-opacity-10 border-0">
                                        <h6 class="mb-0 text-danger">
                                            <i class="fas fa-arrow-up me-2"></i>
                                            Compte Envoyeur
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="envoyeur_id" class="form-label fw-bold">
                                                Sélectionner le compte source
                                            </label>
                                            <select class="form-select form-select-lg" 
                                                    name="envoyeur_id" 
                                                    id="envoyeur_id" 
                                                    required>
                                                <option value="">Choisir le compte envoyeur</option>
                                                @foreach($comptes as $compte)
                                                    <option value="{{ $compte->id }}" 
                                                            data-montant="{{ $compte->montant }}"
                                                            data-nom="{{ $compte->nom }}">
                                                        {{ $compte->nom }} - {{ number_format($compte->montant, 0, ',', ' ') }} FCFA
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Informations du compte sélectionné -->
                                        <div id="sender-info" class="account-info d-none">
                                            <div class="bg-light rounded p-3">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Solde disponible:</span>
                                                    <span class="fw-bold text-success" id="sender-balance">0 FCFA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Flèche de transfert -->
                            <div class="col-lg-2 d-flex align-items-center justify-content-center">
                                <div class="transfer-arrow">
                                    <div class="arrow-container">
                                        <i class="fas fa-arrow-right fa-2x text-primary"></i>
                                        <div class="transfer-amount d-none" id="transfer-display">
                                            <span class="badge bg-primary fs-6">0 FCFA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Compte Receveur -->
                            <div class="col-lg-5">
                                <div class="transfer-card receiver-card">
                                    <div class="card-header bg-success bg-opacity-10 border-0">
                                        <h6 class="mb-0 text-success">
                                            <i class="fas fa-arrow-down me-2"></i>
                                            Compte Receveur
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group mb-3">
                                            <label for="receveur_id" class="form-label fw-bold">
                                                Sélectionner le compte destination
                                            </label>
                                            <select class="form-select form-select-lg" 
                                                    name="receveur_id" 
                                                    id="receveur_id" 
                                                    required>
                                                <option value="">Choisir le compte receveur</option>
                                                @foreach($comptes as $compte)
                                                    <option value="{{ $compte->id }}" 
                                                            data-montant="{{ $compte->montant }}"
                                                            data-nom="{{ $compte->nom }}">
                                                        {{ $compte->nom }} - {{ number_format($compte->montant, 0, ',', ' ') }} FCFA
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        <!-- Informations du compte sélectionné -->
                                        <div id="receiver-info" class="account-info d-none">
                                            <div class="bg-light rounded p-3">
                                                <div class="d-flex justify-content-between">
                                                    <span class="text-muted">Solde actuel:</span>
                                                    <span class="fw-bold text-info" id="receiver-balance">0 FCFA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Section montant -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card border-0 bg-light">
                                    <div class="card-body p-4">
                                        <div class="row align-items-end">
                                            <div class="col-lg-6">
                                                <label for="montant" class="form-label fw-bold">
                                                    <i class="fas fa-money-bill-wave me-2 text-warning"></i>
                                                    Montant à transférer
                                                </label>
                                                <div class="input-group input-group-lg">
                                                    <input type="number" 
                                                           class="form-control" 
                                                           name="montant" 
                                                           id="montant" 
                                                           placeholder="Entrer le montant" 
                                                           min="1" 
                                                           step="1" 
                                                           required>
                                                    <span class="input-group-text bg-warning text-dark fw-bold">FCFA</span>
                                                </div>
                                                <div class="form-text">
                                                    <i class="fas fa-info-circle me-1"></i>
                                                    Le montant doit être supérieur à 0
                                                </div>
                                            </div>
                                            
                                            <div class="col-lg-6">
                                                <div class="transfer-summary d-none" id="transfer-summary">
                                                    <div class="bg-white rounded p-3 border">
                                                        <h6 class="text-muted mb-2">Résumé du transfert</h6>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span>De:</span>
                                                            <span id="summary-from" class="fw-bold">-</span>
                                                        </div>
                                                        <div class="d-flex justify-content-between mb-1">
                                                            <span>Vers:</span>
                                                            <span id="summary-to" class="fw-bold">-</span>
                                                        </div>
                                                        <hr class="my-2">
                                                        <div class="d-flex justify-content-between">
                                                            <span class="fw-bold">Montant:</span>
                                                            <span id="summary-amount" class="fw-bold text-primary">0 FCFA</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-outline-secondary btn-lg me-3">
                                    <i class="fas fa-times me-2"></i>
                                    Annuler
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg" id="transferBtn" disabled>
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Effectuer le Transfert
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Styles personnalisés */
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}

.transfer-steps {
    position: relative;
}

.transfer-steps::before {
    content: '';
    position: absolute;
    top: 25px;
    left: 25%;
    right: 25%;
    height: 2px;
    background: #e9ecef;
    z-index: 1;
}

.step-indicator {
    position: relative;
    z-index: 2;
}

.step-number {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin: 0 auto 10px;
    transition: all 0.3s ease;
}

.step-indicator.active .step-number {
    background: #007bff;
    color: white;
}

.step-indicator.completed .step-number {
    background: #28a745;
    color: white;
}

.step-label {
    font-size: 0.9rem;
    color: #6c757d;
    font-weight: 500;
}

.transfer-card {
    border: 2px solid #e9ecef;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.transfer-card:hover {
    border-color: #007bff;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.1);
}

.sender-card.active {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
}

.receiver-card.active {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.25);
}

.transfer-arrow {
    position: relative;
    text-align: center;
}

.arrow-container {
    animation: pulse 2s infinite;
}

.transfer-amount {
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    white-space: nowrap;
}

.account-info {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.form-select:focus,
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.transfer-summary {
    animation: slideInRight 0.3s ease;
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

@media (max-width: 768px) {
    .transfer-arrow {
        margin: 20px 0;
    }
    
    .transfer-arrow i {
        transform: rotate(90deg);
    }
    
    .transfer-steps::before {
        display: none;
    }
    
    .step-indicator {
        margin-bottom: 15px;
    }
}

/* Animation de chargement */
.loading {
    position: relative;
    overflow: hidden;
}

.loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { left: -100%; }
    100% { left: 100%; }
}
</style>
@endsection

@section('javascript')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const envoyeurSelect = document.getElementById('envoyeur_id');
    const receveurSelect = document.getElementById('receveur_id');
    const montantInput = document.getElementById('montant');
    const transferBtn = document.getElementById('transferBtn');
    const transferForm = document.getElementById('transferForm');

    // Éléments d'affichage
    const senderInfo = document.getElementById('sender-info');
    const receiverInfo = document.getElementById('receiver-info');
    const senderBalance = document.getElementById('sender-balance');
    const receiverBalance = document.getElementById('receiver-balance');
    const transferDisplay = document.getElementById('transfer-display');
    const transferSummary = document.getElementById('transfer-summary');

    // Gestion de la sélection du compte envoyeur
    envoyeurSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const montant = selectedOption.dataset.montant;
            const nom = selectedOption.dataset.nom;
            
            senderBalance.textContent = formatNumber(montant) + ' FCFA';
            senderInfo.classList.remove('d-none');
            
            // Mettre à jour les étapes
            updateStep('step1', true);
            
            // Filtrer les options du receveur
            filterReceiverOptions();
            
            // Activer la carte envoyeur
            document.querySelector('.sender-card').classList.add('active');
        } else {
            senderInfo.classList.add('d-none');
            updateStep('step1', false);
            document.querySelector('.sender-card').classList.remove('active');
        }
        
        validateForm();
        updateSummary();
    });

    // Gestion de la sélection du compte receveur
    receveurSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const montant = selectedOption.dataset.montant;
            const nom = selectedOption.dataset.nom;
            
            receiverBalance.textContent = formatNumber(montant) + ' FCFA';
            receiverInfo.classList.remove('d-none');
            
            // Mettre à jour les étapes
            updateStep('step3', true);
            
            // Activer la carte receveur
            document.querySelector('.receiver-card').classList.add('active');
        } else {
            receiverInfo.classList.add('d-none');
            updateStep('step3', false);
            document.querySelector('.receiver-card').classList.remove('active');
        }
        
        validateForm();
        updateSummary();
    });

    // Gestion du montant
    montantInput.addEventListener('input', function() {
        const montant = parseFloat(this.value) || 0;
        
        if (montant > 0) {
            updateStep('step2', true);
            
            // Afficher le montant sur la flèche
            const badge = transferDisplay.querySelector('.badge');
            badge.textContent = formatNumber(montant) + ' FCFA';
            transferDisplay.classList.remove('d-none');
            
            // Vérifier si le montant est disponible
            const envoyeurMontant = parseFloat(envoyeurSelect.options[envoyeurSelect.selectedIndex]?.dataset.montant) || 0;
            if (montant > envoyeurMontant) {
                this.classList.add('is-invalid');
                this.setCustomValidity('Montant insuffisant');
            } else {
                this.classList.remove('is-invalid');
                this.setCustomValidity('');
            }
        } else {
            updateStep('step2', false);
            transferDisplay.classList.add('d-none');
            this.classList.remove('is-invalid');
        }
        
        validateForm();
        updateSummary();
    });

    // Fonction pour filtrer les options du receveur
    function filterReceiverOptions() {
        const envoyeurId = envoyeurSelect.value;
        const receveurOptions = receveurSelect.querySelectorAll('option');
        
        receveurOptions.forEach(option => {
            if (option.value === envoyeurId) {
                option.style.display = 'none';
                option.disabled = true;
            } else {
                option.style.display = 'block';
                option.disabled = false;
            }
        });
        
        // Réinitialiser la sélection si nécessaire
        if (receveurSelect.value === envoyeurId) {
            receveurSelect.value = '';
            receiverInfo.classList.add('d-none');
            updateStep('step3', false);
            document.querySelector('.receiver-card').classList.remove('active');
        }
    }

    // Fonction pour mettre à jour les étapes
    function updateStep(stepId, completed) {
        const step = document.getElementById(stepId);
        if (completed) {
            step.classList.add('completed');
        } else {
            step.classList.remove('completed');
        }
    }

    // Fonction pour valider le formulaire
    function validateForm() {
        const envoyeurValid = envoyeurSelect.value !== '';
        const receveurValid = receveurSelect.value !== '';
        const montantValid = parseFloat(montantInput.value) > 0;
        const montantSuffisant = parseFloat(montantInput.value) <= parseFloat(envoyeurSelect.options[envoyeurSelect.selectedIndex]?.dataset.montant || 0);
        const comptesDifferents = envoyeurSelect.value !== receveurSelect.value;
        
        const isValid = envoyeurValid && receveurValid && montantValid && montantSuffisant && comptesDifferents;
        
        transferBtn.disabled = !isValid;
        
        if (isValid) {
            transferBtn.classList.remove('btn-outline-primary');
            transferBtn.classList.add('btn-primary');
        } else {
            transferBtn.classList.remove('btn-primary');
            transferBtn.classList.add('btn-outline-primary');
        }
    }

    // Fonction pour mettre à jour le résumé
    function updateSummary() {
        const envoyeurNom = envoyeurSelect.options[envoyeurSelect.selectedIndex]?.dataset.nom || '';
        const receveurNom = receveurSelect.options[receveurSelect.selectedIndex]?.dataset.nom || '';
        const montant = parseFloat(montantInput.value) || 0;
        
        if (envoyeurNom && receveurNom && montant > 0) {
            document.getElementById('summary-from').textContent = envoyeurNom;
            document.getElementById('summary-to').textContent = receveurNom;
            document.getElementById('summary-amount').textContent = formatNumber(montant) + ' FCFA';
            transferSummary.classList.remove('d-none');
        } else {
            transferSummary.classList.add('d-none');
        }
    }

    // Fonction pour formater les nombres
    function formatNumber(number) {
        return new Intl.NumberFormat('fr-FR').format(number);
    }

    // Gestion de la soumission du formulaire
    transferForm.addEventListener('submit', function(e) {
        transferBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Transfert en cours...';
        transferBtn.disabled = true;
        transferBtn.classList.add('loading');
    });

    // Auto-dismiss des alertes
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
@endsection