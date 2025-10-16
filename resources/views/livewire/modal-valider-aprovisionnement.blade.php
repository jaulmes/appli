<div>
  <form action="{{ route('achat.valider') }}" method="post">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow-lg">
          
          <!-- Header -->
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title d-flex align-items-center" id="exampleModalLabel">
              <i class="fas fa-shopping-cart me-2"></i>
              Finaliser l'achat
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          
          <!-- Body -->
          <div class="modal-body p-4">
            <div class="row g-4">
              
              <!-- Montant versé -->
              <div class="col-12">
                <div class="form-group">
                  <label for="montantVerse" class="form-label fw-semibold">
                    <i class="fas fa-money-bill-wave text-success me-2"></i>
                    Montant versé
                  </label>
                  <div class="input-group input-group-lg">
                    <span class="input-group-text bg-light">
                      <i class="fas fa-dollar-sign"></i>
                    </span>
                    <input 
                      class="form-control" 
                      type="number" 
                      name="montantVerse" 
                      id="montantVerse" 
                      value="{{ Cart::getTotal() }}" 
                      min="0"
                      step="0.01"
                      required
                      placeholder="Entrez le montant"
                    >
                  </div>
                  <small class="text-muted">Total du panier: {{ $this->panierTotal() }} FCFA</small>
                </div>
              </div>
              
              <!-- Mode de paiement -->
              <div class="col-12">
                <div class="form-group">
                  <label for="modePaiement" class="form-label fw-semibold">
                    <i class="fas fa-credit-card text-primary me-2"></i>
                    Mode de paiement
                  </label>
                  <select class="form-select form-select-lg" name="modePaiement" id="modePaiement" required>
                    <option value="" selected disabled>Sélectionnez un mode de paiement</option>
                    @foreach($comptes as $compte)
                      <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              
              <!-- Accepter les conditions -->
              <div class="col-12">
                <div class="form-check p-3 bg-light rounded">
                  <input 
                    type="checkbox" 
                    class="form-check-input" 
                    name="impot" 
                    id="impot"
                    
                  >
                  <label class="form-check-label fw-semibold" for="impot">
                    <i class="fas fa-check-circle text-success me-2"></i>
                    J'accepte
                  </label>
                </div>
              </div>
              
            </div>
          </div>
          
          <!-- Footer -->
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
              <i class="fas fa-times me-2"></i>
              Annuler
            </button>
            <button type="submit" class="btn btn-primary px-4">
              <i class="fas fa-check me-2"></i>
              Confirmer l'achat
            </button>
          </div>
          
        </div>
      </div>
    </div>
  </form>
  <style>
/* Styles personnalisés supplémentaires */
.modal-content {
  border-radius: 12px;
  overflow: hidden;
}

.modal-header {
  padding: 1.25rem 1.5rem;
  border-bottom: none;
}

.modal-body {
  background-color: #ffffff;
}

.form-label {
  margin-bottom: 0.5rem;
  color: #2c3e50;
}

.form-control:focus,
.form-select:focus {
  border-color: #0d6efd;
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.input-group-text {
  border-right: none;
}

.input-group .form-control {
  border-left: none;
}

.input-group:focus-within .input-group-text {
  border-color: #0d6efd;
  background-color: #e7f1ff;
}

.form-check-input:checked {
  background-color: #198754;
  border-color: #198754;
}

.btn {
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.modal-footer {
  border-top: 1px solid #e9ecef;
  padding: 1rem 1.5rem;
}
</style>
</div>

