<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="consumption-card p-4 mb-4">
            <div class="consumption-card p-4 mb-4">

                <h2 class="mb-4 text-center text-primary"><i class="fas fa-bolt me-2"></i>Simulateur de Consommation</h2>

                <div class="appareil">
                    <!-- Formulaire de saisie -->
                    @foreach($appareils as $index => $appareil)
                        <div class="dynamic-input-group mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" 
                                        class="form-control @error('appareil.{$index}.name') is-invalid @enderror"
                                        wire:model.defer="appareils.{{ $index }}.name"
                                        placeholder="Appareil" required>
                                    @error("appareil.{$index}.name")
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror    
                                </div>
                                <div class="col-md-2">
                                @error("appareil.{$index}.quantity")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror 
                                    <input type="number" 
                                        class="form-control" 
                                        wire:model.defer="appareils.{{ $index }}.quantity"
                                        placeholder="Quantité">
    
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="number" 
                                            class="form-control" 
                                            wire:model.defer="appareils.{{ $index }}.power"
                                            placeholder="Puissance"
                                            min="0">
                                        <span class="input-group-text">W</span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input type="number" 
                                            class="form-control" 
                                            wire:model.defer="appareils.{{ $index }}.duration"
                                            placeholder="Durée"
                                            min="0"
                                            step="0.5">
                                        <span class="input-group-text">h/j</span>
                                    </div>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-danger btn-sm" 
                                            wire:click="retirerAppareil({{ $index }})"
                                            @if(count($appareils) === 1) disabled @endif>
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @error("appareils.{$index}.*") <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    @endforeach
                </div>
                <button class="btn btn-success w-100 mb-4" wire:click="ajouterAppareil">
                    <i class="fas fa-plus-circle me-2"></i>Ajouter un appareil
                </button>
            </div>
            

            <!-- Paramètres supplémentaires -->
            <div class="consumption-card p-4 mb-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Coefficient de sécurité</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="coeficient_securite"  required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tension d'entrée des panneaux</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="tension_entre_panneau"  required>
                            <span class="input-group-text">V</span>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ensoleillement du site</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="ensoleillement_site"  required>
                            <span class="input-group-text">h/j</span>
                        </div>
                    </div>

                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label">Efficacité de l'installation</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="efficacite_installation"  required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Autonomie Generale</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="autonomie_generale"    required>
                            <span class="input-group-text">jrs</span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Tension d'une batterie</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="tension_batterie"  required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Tension de sortie park batterie</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="tension_sortie_batterie"  required>
                            <span class="input-group-text">V</span>
                        </div>
                    </div>
                    <div class="col-md-3 display-right">
                        <label class="form-label">DOD de batterie</label>
                        <div class="input-group">
                            <input type="number" class="form-control" wire:model.defer="DOD_batterie"  required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="consumption-card p-4 mb-4">
                <div class="col-md-9 display-right">
                    <label class="form-label">Vous souhaitez realiser le projet en panneaux de combien de watt?</label>
                    <div class="input-group">
                        <input type="number" class="form-control" wire:model.defer="nombre_watt_panneaux"  required>
                        <span class="input-group-text">W</span>
                        @error('nombre_watt_panneaux')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                    <label class="form-label">Vous souhaitez realiser le projet en batterie de combien d'Ah ou de Wh?</label>
                    <div class="col-md-9  display-right">
                    <div class="alert alert-info" role="alert">
                        Veuillez cocher une case.
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:change="handleUniteBatterie()" wire:model="unite_batterie" id="exampleRadios1" value="Ah" >
                        <label class="form-check-label" for="exampleRadios1">
                            Ah
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" wire:change="handleUniteBatterie()" wire:model="unite_batterie"  id="exampleRadios2" value="Wh">
                        <label class="form-check-label" for="exampleRadios2">
                            Wh
                        </label>
                    </div>
                    @error('unite_batterie')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    <div class="input-group">
                        <input type="number" class="form-control" wire:model.defer="batteri_souhaite"  required>
                        <span class="input-group-text">@if($unite_batterie === 'Wh') {{$unite_batterie}} @elseif($unite_batterie === 'Ah') Ah @endif </span>
                        @error('batteri_souhaite')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label d-block mb-2">Quel type de convertisseur souhaitez-vous utiliser ?</label>
                        <div class="d-flex gap-4">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    wire:model="convertisseur_type"
                                    wire:change="handleTypeConvertisseur"
                                    id="pure_sinus"
                                    value="pure_sinus"
                                >
                                <label class="form-check-label" for="pure_sinus">
                                    Pur sinus
                                </label>
                            </div>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="radio"
                                    wire:model="convertisseur_type"
                                    wire:change="handleTypeConvertisseur"
                                    id="sinus_modifie"
                                    value="sinus_modifie"
                                >
                                <label class="form-check-label" for="sinus_modifie">
                                    Sinus modifié
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="consumption-card p-4 mb-4">
                <button
                    type="button"
                    class="btn btn-primary w-100 py-3 d-flex justify-content-center align-items-center"
                    wire:click="simuller"
                    wire:loading.attr="disabled"
                >
                <i class="fas fa-calculator me-2"></i>
                <span>Valider</span>


                <div
                    class="spinner-border spinner-border-sm ms-2"
                    role="status"
                    wire:loading
                >
                    <span class="visually-hidden">Chargement…</span>
                </div>
                </button>

            </div>
        </div>

        <!-- Résultats -->
        @if($showResults === true)
            <div id="results" class="consumption-card p-4" >
                <h4 class="mb-4 text-center text-success"><i class="fas fa-solar-panel me-2"></i>Résultats de Simulation</h4>

                <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                    <div class="col">
                        <div class="alert alert-success h-100">
                            <h5 class="alert-heading">Besoin energetique journalier </h5>
                            <hr>
                            <p class="display-6 mb-0"><span id="dailyConsumption">{{$besoin_energetique_journalier}}</span> <small>Wh/jour</small></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="alert alert-warning h-100">
                            <h5 class="alert-heading">Puissance du convertisseur</h5>
                            <hr>
                            <p class="display-6 mb-0"><span id="requiredAutonomy">{{$puissance_convertisseur}}</span> <small>W</small></p>
                        </div>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                    <div class="col">
                        <div class="alert alert-dark h-100">
                            <h5 class="alert-heading">Nombre de batterie </h5>
                            <hr>
                            <p class="display-6 mb-0"><span id="dailyConsumption">{{number_format($nombre_batteries, '2', ',', ' ') }}</span> <small>batteries</small></p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="alert alert-info h-100">
                            <h5 class="alert-heading">Nombre de panneaux</h5>
                            <hr>
                            <p class="display-6 mb-0"><span id="requiredAutonomy">{{number_format($nombre_panneaux, 2, ',', ' ') }}</span> <small>panneaux</small></p>
                        </div>
                    </div>
                </div>

                <div class="progress mb-4" style="height: 35px;">
                    <div class="progress-bar progress-bar-striped progress-bar-energy" 
                        role="progressbar" 
                        style="width: 0%" 
                        aria-valuenow="0" 
                        aria-valuemin="0" 
                        aria-valuemax="100">
                        <span class="h5 mb-0" id="solarCoverage">0% couverture solaire</span>
                    </div>
                </div>

                <div class="alert alert-success">
                    <h5 class="alert-heading">Solution Solaire Complète</h5>
                    <hr>
                    <dl class="row mb-0">
                        <dt class="col-sm-8">Puissance champ panneaux</dt>
                        <dd class="col-sm-4"><span id="requiredPower">{{ $puissance_champ_panneaux}}</span> Wc</dd>

                        <dt class="col-sm-8">Nombre de panneaux</dt>
                        <dd class="col-sm-4"><span id="spaceRequired">{{$nombre_panneaux}}</span> </dd>

                        <dt class="col-sm-8">Capacité batterie </dt>
                        <dd class="col-sm-4"><span id="panelsRequired">{{ $capacite_batterie}}</span>{{$unite_capacite_batterie}}</dd>

                        <dt class="col-sm-8">Nombre de batterie </dt>
                        <dd class="col-sm-4"><span id="panelsRequired">{{ $nombre_batteries}}</span></dd>

                        <dt class="col-sm-8">Courant minimum controlleur</dt>
                        <dd class="col-sm-4"><span id="batteryCapacity">{{ $courant_minimun_controlleur}}</span> A</dd>

                        <dt class="col-sm-8">Puissance du convertiseur</dt>
                        <dd class="col-sm-4"><span id="spaceRequired">{{$puissance_convertisseur}}</span> W</dd>
                    </dl>
                </div>
            </div>
            <button 
                type="button" 
                class="btn btn-primary" 
                data-bs-toggle="modal" 
                data-bs-target="#reportModal">
                Télécharger le rapport
            </button>

            <!-- Modal -->
            <div class="modal fade" wire:ignore.self id="reportModal" tabindex="-1" aria-labelledby="reportModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-sm-down modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel">Rapport de simulation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                    <div class="row gy-3">
                        {{-- Vos coordonnées --}}
                        <div class="col-12 col-md-6">
                        <div class="card p-3 h-100">
                            <h5 class="text-dark"> <u>Vos coordonnées</u> </h5>

                            <div class="mb-2">
                            <label for="nom_simuleur" class="form-label">Nom<span style="color: red;">*</span></label>
                            <input 
                                type="text" 
                                id="nom_simuleur" 
                                class="form-control @error('nom_simuleur') is-invalid @enderror" 
                                wire:model.defer="nom_simuleur" 
                                placeholder="Entrez votre nom">
                            @error('nom_simuleur') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>

                            <div class="mb-2">
                            <label for="numero_telephone_simuleur" class="form-label">Téléphone(whatsapp)<span style="color: red;">*</span></label>
                            <input 
                                type="tel" 
                                id="numero_telephone_simuleur" 
                                class="form-control @error('numero_telephone_simuleur') is-invalid @enderror" 
                                wire:model.defer="numero_telephone_simuleur" 
                                placeholder="Entrez votre numéro">
                            @error('numero_telephone_simuleur') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>

                            <div class="mb-0">
                            <label for="adresse_simuleur" class="form-label">Adresse</label>
                            <input 
                                type="text" 
                                id="adresse_simuleur" 
                                class="form-control @error('adresse_simuleur') is-invalid @enderror" 
                                wire:model.defer="adresse_simuleur" 
                                placeholder="Entrez votre adresse">
                            @error('adresse_simuleur') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>
                        </div>
                        </div>

                        {{-- Coordonnées du client --}}
                        <div class="col-12 col-md-6">
                        <div class="card p-3 h-100">
                            <h5 class="text-dark"> <u>Coordonnées du client</u> </h5>

                            <div class="mb-2">
                            <label for="nom_client" class="form-label">Nom </label>
                            <input 
                                type="text" 
                                id="nom_client" 
                                class="form-control @error('nom_client') is-invalid @enderror" 
                                wire:model.defer="nom_client" 
                                placeholder="Entrez le nom">
                            @error('nom_client') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>

                            <div class="mb-2">
                            <label for="numero_telephone_client" class="form-label">Téléphone</label>
                            <input 
                                type="tel" 
                                id="numero_telephone_client" 
                                class="form-control @error('numero_telephone_client') is-invalid @enderror" 
                                wire:model.defer="numero_telephone_client" 
                                placeholder="Entrez le numéro">
                            @error('numero_telephone_client') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>

                            <div class="mb-0">
                            <label for="adresse_client" class="form-label">Adresse</label>
                            <input 
                                type="text" 
                                id="adresse_client" 
                                class="form-control @error('adresse_client') is-invalid @enderror" 
                                wire:model.defer="adresse_client" 
                                placeholder="Entrez l’adresse">
                            @error('adresse_client') 
                                <div class="invalid-feedback">{{ $message }}</div> 
                            @enderror
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Fermer
                    </button>
                    <button 
                    type="button" 
                    class="btn btn-primary d-flex align-items-center" 
                    wire:click="generatePdf" 
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Générer le PDF</span>
                    <span wire:loading class="spinner-border spinner-border-sm ms-2" role="status"></span>
                    </button>
                </div>
                </div>
            </div>
            </div>

        @endif
    </div>
    

    <style>
  
    
    .consumption-card {
        background: #ffffff;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .dynamic-input-group {
        border-left: 3px solid var(--bs-primary);
        padding-left: 1rem;
        margin-bottom: 1rem;
    }

    .progress-bar-energy {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        animation: gradient 3s ease infinite;
    }

    @keyframes gradient {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    </style>
</div>

