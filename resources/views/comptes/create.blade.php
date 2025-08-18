@extends('dashboard.main')

@section('head')
<!-- Optimisation des ressources CSS -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css">
<link rel="stylesheet" href="../../dist/css/adminlte.min.css">

<!-- Styles personnalisés -->
<style>
    :root {
        --primary-color: #007bff;
        --primary-dark: #0056b3;
        --success-color: #28a745;
        --danger-color: #dc3545;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --border-radius: 12px;
        --box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .main-container {
        padding: 2rem 0;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        border: none;
        overflow: hidden;
        transition: var(--transition);
    }

    .form-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(255,255,255,0.05) 10px,
            rgba(255,255,255,0.05) 20px
        );
        animation: float 20s infinite linear;
    }

    @keyframes float {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .form-header-content {
        position: relative;
        z-index: 2;
    }

    .form-header h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.75rem;
        font-weight: 600;
    }

    .form-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 1rem;
    }

    .form-body {
        padding: 2.5rem;
    }

    .form-step {
        display: none;
        animation: fadeInSlide 0.5s ease-out;
    }

    .form-step.active {
        display: block;
    }

    @keyframes fadeInSlide {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin: 0 1rem;
        position: relative;
        transition: var(--transition);
    }

    .step.active {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
    }

    .step.completed {
        background: var(--success-color);
        color: white;
    }

    .step::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 100%;
        width: 2rem;
        height: 2px;
        background: #e9ecef;
        transform: translateY(-50%);
    }

    .step:last-child::after {
        display: none;
    }

    .step.completed::after {
        background: var(--success-color);
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        color: var(--dark-color);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: var(--transition);
        background: #f8f9fa;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        background: white;
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
    }

    .form-control.is-valid {
        border-color: var(--success-color);
        box-shadow: 0 0 0 0.2rem rgba(40,167,69,0.25);
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 5;
    }

    .form-control.has-icon {
        padding-left: 3rem;
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: var(--danger-color);
        margin-top: 0.25rem;
        animation: shake 0.5s ease-in-out;
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    .btn-group {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: var(--transition);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,123,255,0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .progress-container {
        margin-bottom: 2rem;
    }

    .progress {
        height: 6px;
        border-radius: 3px;
        background: #e9ecef;
        overflow: hidden;
    }

    .progress-bar {
        background: linear-gradient(90deg, var(--primary-color), var(--success-color));
        transition: width 0.5s ease;
    }

    .account-preview {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: var(--border-radius);
        padding: 1.5rem;
        margin-top: 1rem;
        border: 2px dashed #dee2e6;
    }

    .preview-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #dee2e6;
    }

    .preview-item:last-child {
        border-bottom: none;
    }

    .alert {
        border-radius: var(--border-radius);
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-spinner {
        background: white;
        padding: 2rem;
        border-radius: var(--border-radius);
        text-align: center;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid var(--primary-color);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 0 auto 1rem;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-body {
            padding: 1.5rem;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .step {
            margin: 0 0.5rem;
        }
    }
</style>
@endsection

@section('content')
<div class="main-container">
    <div class="container-fluid">
        <div class="form-container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard.compte') }}" class="text-decoration-none">
                            <i class="fas fa-wallet me-1"></i>Comptes
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Nouveau compte</li>
                </ol>
            </nav>

            <!-- Messages d'erreur -->
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Erreurs détectées :</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Formulaire principal -->
            <div class="form-card">
                <div class="form-header">
                    <div class="form-header-content">
                        <h3><i class="fas fa-plus-circle me-2"></i>Nouveau Moyen de Paiement</h3>
                        <p>Ajoutez un nouveau compte pour gérer vos finances</p>
                    </div>
                </div>

                <div class="form-body">
                    <!-- Indicateur de progression -->
                    <div class="progress-container">
                        <div class="progress">
                            <div class="progress-bar" id="formProgress" style="width: 33%"></div>
                        </div>
                        <div class="text-center mt-2">
                            <small class="text-muted">Étape <span id="currentStep">1</span> sur 3</small>
                        </div>
                    </div>

                    <!-- Indicateurs d'étapes -->
                    <div class="step-indicator">
                        <div class="step active" data-step="1">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="step" data-step="2">
                            <i class="fas fa-info"></i>
                        </div>
                        <div class="step" data-step="3">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>

                    <form method="post" action="{{ route('dashboard.compte.store') }}" id="accountForm">
                        @csrf
                        
                        <!-- Étape 1: Informations de base -->
                        <div class="form-step active" data-step="1">
                            <h5 class="mb-4 text-center">
                                <i class="fas fa-id-card me-2 text-primary"></i>
                                Informations de Base
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="nom" class="form-label">
                                            <i class="fas fa-tag text-primary"></i>
                                            Nom du Compte
                                        </label>
                                        <div class="input-group">
                                            <i class="fas fa-wallet input-icon"></i>
                                            <input name="nom" 
                                                   type="text" 
                                                   class="form-control has-icon @error('nom') is-invalid @enderror" 
                                                   id="nom" 
                                                   placeholder="Ex: Compte Orange Money, Visa, Espèces..."
                                                   value="{{ old('nom') }}"
                                                   required>
                                        </div>
                                        @error('nom')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Donnez un nom reconnaissable à votre compte</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 2: Détails du compte -->
                        <div class="form-step" data-step="2">
                            <h5 class="mb-4 text-center">
                                <i class="fas fa-cogs me-2 text-primary"></i>
                                Détails du Compte
                            </h5>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero" class="form-label">
                                            <i class="fas fa-hashtag text-info"></i>
                                            Numéro de Compte
                                        </label>
                                        <div class="input-group">
                                            <i class="fas fa-credit-card input-icon"></i>
                                            <input name="numero" 
                                                   type="number" 
                                                   class="form-control has-icon @error('numero') is-invalid @enderror" 
                                                   id="numero" 
                                                   placeholder="Ex: 695123456"
                                                   value="{{ old('numero') }}"
                                                   required>
                                        </div>
                                        @error('numero')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Numéro de téléphone, carte, etc.</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="montant" class="form-label">
                                            <i class="fas fa-money-bill-wave text-success"></i>
                                            Solde Initial
                                        </label>
                                        <div class="input-group">
                                            <i class="fas fa-coins input-icon"></i>
                                            <input name="montant" 
                                                   type="number" 
                                                   class="form-control has-icon @error('montant') is-invalid @enderror" 
                                                   id="montant" 
                                                   placeholder="0"
                                                   value="{{ old('montant', 0) }}"
                                                   min="0"
                                                   step="1"
                                                   required>
                                            <span class="input-group-text bg-success text-white">FCFA</span>
                                        </div>
                                        @error('montant')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Montant actuellement disponible</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Étape 3: Confirmation -->
                        <div class="form-step" data-step="3">
                            <h5 class="mb-4 text-center">
                                <i class="fas fa-eye me-2 text-primary"></i>
                                Vérification et Confirmation
                            </h5>
                            
                            <div class="account-preview">
                                <h6 class="text-center mb-3">
                                    <i class="fas fa-clipboard-check me-2"></i>
                                    Aperçu du Compte
                                </h6>
                                
                                <div class="preview-item">
                                    <span class="fw-bold">
                                        <i class="fas fa-tag me-2 text-primary"></i>
                                        Nom du compte :
                                    </span>
                                    <span id="preview-nom">-</span>
                                </div>
                                
                                <div class="preview-item">
                                    <span class="fw-bold">
                                        <i class="fas fa-hashtag me-2 text-info"></i>
                                        Numéro :
                                    </span>
                                    <span id="preview-numero">-</span>
                                </div>
                                
                                <div class="preview-item">
                                    <span class="fw-bold">
                                        <i class="fas fa-money-bill-wave me-2 text-success"></i>
                                        Solde initial :
                                    </span>
                                    <span id="preview-montant" class="text-success fw-bold">0 FCFA</span>
                                </div>
                            </div>
                            
                            <div class="text-center mt-3">
                                <p class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Vérifiez les informations avant de créer le compte
                                </p>
                            </div>
                        </div>

                        <!-- Boutons de navigation -->
                        <div class="btn-group">
                            <button type="button" 
                                    class="btn btn-secondary" 
                                    id="prevBtn"
                                    style="display: none;">
                                <i class="fas fa-arrow-left"></i>
                                Précédent
                            </button>
                            
                            <button type="button" 
                                    class="btn btn-primary" 
                                    id="nextBtn">
                                Suivant
                                <i class="fas fa-arrow-right"></i>
                            </button>
                            
                            <button type="submit" 
                                    class="btn btn-success" 
                                    id="submitBtn"
                                    style="display: none;">
                                <i class="fas fa-save"></i>
                                Créer le Compte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Overlay de chargement -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <h6>Création du compte en cours...</h6>
        <p class="text-muted">Veuillez patienter</p>
    </div>
</div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    let currentStep = 1;
    const totalSteps = 3;
    
    // Éléments du DOM
    const $form = $('#accountForm');
    const $prevBtn = $('#prevBtn');
    const $nextBtn = $('#nextBtn');
    const $submitBtn = $('#submitBtn');
    const $progress = $('#formProgress');
    const $currentStepText = $('#currentStep');
    
    // Fonction pour mettre à jour l'affichage des étapes
    function updateStepDisplay() {
        // Masquer toutes les étapes
        $('.form-step').removeClass('active');
        $('.step').removeClass('active completed');
        
        // Afficher l'étape actuelle
        $(`.form-step[data-step="${currentStep}"]`).addClass('active');
        
        // Mettre à jour les indicateurs
        for (let i = 1; i <= totalSteps; i++) {
            const $step = $(`.step[data-step="${i}"]`);
            if (i < currentStep) {
                $step.addClass('completed');
            } else if (i === currentStep) {
                $step.addClass('active');
            }
        }
        
        // Mettre à jour la barre de progression
        const progressPercent = (currentStep / totalSteps) * 100;
        $progress.css('width', progressPercent + '%');
        $currentStepText.text(currentStep);
        
        // Gérer l'affichage des boutons
        $prevBtn.toggle(currentStep > 1);
        $nextBtn.toggle(currentStep < totalSteps);
        $submitBtn.toggle(currentStep === totalSteps);
    }
    
    // Fonction de validation des étapes
    function validateStep(step) {
        let isValid = true;
        
        switch (step) {
            case 1:
                const nom = $('#nom').val().trim();
                if (!nom) {
                    showFieldError('#nom', 'Le nom du compte est requis');
                    isValid = false;
                } else if (nom.length < 3) {
                    showFieldError('#nom', 'Le nom doit contenir au moins 3 caractères');
                    isValid = false;
                } else {
                    clearFieldError('#nom');
                }
                break;
                
            case 2:
                const numero = $('#numero').val().trim();
                const montant = $('#montant').val();
                
                if (!numero) {
                    showFieldError('#numero', 'Le numéro est requis');
                    isValid = false;
                } else {
                    clearFieldError('#numero');
                }
                
                if (montant < 0) {
                    showFieldError('#montant', 'Le montant ne peut pas être négatif');
                    isValid = false;
                } else {
                    clearFieldError('#montant');
                }
                break;
        }
        
        return isValid;
    }
    
    // Fonctions d'aide pour les erreurs
    function showFieldError(fieldId, message) {
        const $field = $(fieldId);
        $field.addClass('is-invalid').removeClass('is-valid');
        
        let $feedback = $field.siblings('.invalid-feedback');
        if ($feedback.length === 0) {
            $feedback = $('<div class="invalid-feedback"></div>');
            $field.after($feedback);
        }
        $feedback.text(message);
    }
    
    function clearFieldError(fieldId) {
        const $field = $(fieldId);
        $field.removeClass('is-invalid').addClass('is-valid');
        $field.siblings('.invalid-feedback').remove();
    }
    
    // Fonction pour mettre à jour l'aperçu
    function updatePreview() {
        $('#preview-nom').text($('#nom').val() || '-');
        $('#preview-numero').text($('#numero').val() || '-');
        
        const montant = $('#montant').val() || '0';
        $('#preview-montant').text(formatNumber(montant) + ' FCFA');
    }
    
    // Fonction pour formater les nombres
    function formatNumber(number) {
        return new Intl.NumberFormat('fr-FR').format(number);
    }
    
    // Événements des boutons
    $nextBtn.on('click', function() {
        if (validateStep(currentStep)) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateStepDisplay();
                if (currentStep === 3) {
                    updatePreview();
                }
            }
        }
    });
    
    $prevBtn.on('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateStepDisplay();
        }
    });
    
    // Validation en temps réel
    $('#nom').on('input', function() {
        const val = $(this).val().trim();
        if (val.length >= 3) {
            clearFieldError('#nom');
        }
    });
    
    $('#numero').on('input', function() {
        const val = $(this).val().trim();
        if (val) {
            clearFieldError('#numero');
        }
    });
    
    $('#montant').on('input', function() {
        const val = parseFloat($(this).val()) || 0;
        if (val >= 0) {
            clearFieldError('#montant');
        }
        
        // Mise à jour en temps réel du formatage
        $(this).next('.input-group-text').text(formatNumber(val) + ' FCFA');
    });
    
    // Soumission du formulaire
    $form.on('submit', function(e) {
        e.preventDefault();
        
        if (!validateStep(1) || !validateStep(2)) {
            alert('Veuillez corriger les erreurs avant de soumettre');
            return;
        }
        
        // Afficher le loading
        $('#loadingOverlay').fadeIn();
        
        // Simuler un délai puis soumettre
        setTimeout(() => {
            this.submit();
        }, 1000);
    });
    
    // Navigation par clic sur les étapes
    $('.step').on('click', function() {
        const targetStep = parseInt($(this).data('step'));
        
        // Vérifier si on peut aller à cette étape
        let canNavigate = true;
        for (let i = 1; i < targetStep; i++) {
            if (!validateStep(i)) {
                canNavigate = false;
                break;
            }
        }
        
        if (canNavigate) {
            currentStep = targetStep;
            updateStepDisplay();
            if (currentStep === 3) {
                updatePreview();
            }
        }
    });
    
    // Initialisation
    updateStepDisplay();
    
    // Auto-dismiss des alertes
    setTimeout(() => {
        $('.alert').fadeOut();
    }, 5000);
});
</script>
@endsection