<div class="container my-4">
    <div class="text-center mb-4">
        <h4 class="fw-bold text-uppercase text-primary">
            Bilan Financier du Mois
        </h4>
        <p class="text-muted">Détail des bénéfices et charges pour le mois sélectionné</p>
    </div>

    <div class="row justify-content-center g-4">
        <!-- Bénéfice Brut -->
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="bi bi-cash-coin text-success fs-1 mb-2"></i>
                    <h6 class="text-muted">Bénéfice Brut</h6>
                    <h5 class="fw-bold text-success">{{$beneficeBrute}} FCFA</h5>
                </div>
            </div>
        </div>

        <!-- Charges -->
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="bi bi-receipt text-danger fs-1 mb-2"></i>
                    <h6 class="text-muted">Total des Charges</h6>
                    <h5 class="fw-bold text-danger">{{$totalCharge}} FCFA</h5>
                </div>
            </div>
        </div>

        <!-- Bénéfice Réel -->
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up-arrow text-primary fs-1 mb-2"></i>
                    <h6 class="text-muted">Bénéfice Réel</h6>
                    <h5 class="fw-bold text-primary">{{$beneficeReele}} FCFA</h5>
                </div>
            </div>
        </div>
    </div>
</div>
