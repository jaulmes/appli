
    <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Enregistrement de la transaction - Total: {{ $this->panierTotal() }} F CFA</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        
        <div class="modal-body">

            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="bi bi-info-circle-fill me-2"></i>
                <div>Veuillez choisir une option pour continuer</div>
            </div>

            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model="formulaire_affiche" 
                           wire:change="toggleFormulaire" id="option1" value="vente" name="formulaire">
                    <label class="form-check-label fw-bold" for="option1">
                        Vente de produit
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" wire:model="formulaire_affiche" 
                           wire:click="toggleFormulaire" id="option2" value="installation" name="formulaire">
                    <label class="form-check-label fw-bold" for="option2">
                        Installation solaire
                    </label>
                </div>
                @if(session('error_html'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {!! session('error_html') !!}
                    </div>
                @endif
            </div>

            @if($formulaire_affiche === 'vente')
                <div class="border-top pt-3 p-3 shadow-lg rounded-3 bg-white" style="text-align: center;">
                    <h6 class="mb-3 fw-bold"> <u>Formulaire de vente</u> </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <div class="input-group">
                                <label for="client" class="mr-4">Choisir le client: </label>
                                <select class="form-select mr-4" id="client" wire:model="client_id">
                                    <option selected >Choisir un client existant...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-primary" wire:click="toggleClientForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau client
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($nouveau_client === 'true')
                        <div class="row g-3 mb-4 border-top pt-3 p-3 shadow-lg rounded-3 bg-white">
                            <div class="col-md-6">
                                <label class="form-label">Nom du client</label>
                                <input type="text" class="form-control" wire:model="nom_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro du client</label>
                                <input type="number" class="form-control" wire:model="numero_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email du client</label>
                                <input type="text" class="form-control" wire:model="email_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adresse du client</label>
                                <input type="text" class="form-control" wire:model="adresse_client" required>
                            </div>
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Montant versé</label>
                            <input type="number" class="form-control" wire:model="montant_verse" wire:change="$refresh" value="{{ $this->panierTotal() }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Réduction</label>
                            <div class="input-group">
                                <input type="number" class="form-control" wire:change="$refresh" wire:model="reduction"  required>
                                <span class="input-group-text">F CFA</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mode de paiement</label>
                            <select class="form-select" wire:model="mode_paiement" required>
                                <option selected >Choisir le mode de paiement...</option>
                                @foreach($comptes as $compte)
                                    <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        @if(!is_null($montant_verse) && !is_null($reduction)) 
                            @if($this->panierTotal() - $reduction > $montant_verse)
                                <div class="col-md-4">
                                    <label class="form-label">Date limite de paiement</label>
                                    <input type="date" class="form-control" wire:model="dateLimitePaiement" required>
                                </div>
                            @endif
                        @endif
                            
                        <div class="col-md-4">
                            <label class="form-label">Commission</label>
                            <input type="number" class="form-control" wire:model="commission" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agent opérant</label>
                            <input type="text" class="form-control" wire:model="agent_operant" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="impot" id="impot">
                                <label class="form-check-label" for="impot">
                                    Accepter 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary" wire:click="enregistrer_vente()">
                            <i class="bi bi-save me-2"></i>Enregistrer
                        </button>
                    </div>
                </div>
            @endif

            @if($formulaire_affiche === 'installation')
                <div class="border-top pt-3 p-3 shadow-lg rounded-3 bg-white" style="text-align: center;">
                    <h6 class="mb-3 fw-bold"> <u>Formulaire d'installation</u> </h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-8">
                            <div class="input-group">
                                <label for="client" class="mr-4">Choisir le client: </label>
                                <select class="form-select mr-4" id="client" wire:model="client_id">
                                    <option selected >Choisir un client existant...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-outline-primary" wire:click="toggleClientForm()">
                                    <i class="bi bi-plus-circle"></i> Nouveau client
                                </button>
                            </div>
                        </div>
                    </div>

                    @if($nouveau_client === 'true')
                        <div class="row g-3 mb-4 border-top pt-3 p-3 shadow-lg rounded-3 bg-white">
                            <div class="col-md-6">
                                <label class="form-label">Nom du client</label>
                                <input type="text" class="form-control" wire:model="nom_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro du client</label>
                                <input type="number" class="form-control" wire:model="numero_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email du client</label>
                                <input type="text" class="form-control" wire:model="email_client" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adresse du client</label>
                                <input type="text" class="form-control" wire:model="adresse_client" required>
                            </div>
                        </div>
                    @endif

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Montant versé</label>
                            <input type="number" class="form-control" wire:model="montant_verse" wire:change="$refresh" value="{{ $this->panierTotal() }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Réduction</label>
                            <div class="input-group">
                                <input type="number" class="form-control" wire:change="$refresh" wire:model="reduction"  required>
                                <span class="input-group-text">F CFA</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mode de paiement</label>
                            <select class="form-select" wire:model="mode_paiement" required>
                                <option selected >Choisir le mode de paiement...</option>
                                @foreach($comptes as $compte)
                                    <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        @if(!is_null($montant_verse) && !is_null($reduction)) 
                            @if($this->panierTotal() - $reduction > $montant_verse)
                                <div class="col-md-4">
                                    <label class="form-label">Date limite de paiement</label>
                                    <input type="date" class="form-control" wire:model="dateLimitePaiement" required>
                                </div>
                            @endif
                        @endif
                        <div class="col-md-4">
                            <label class="form-label">Installation</label>
                            <input type="number" class="form-control" wire:model="frais_installation" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Commission</label>
                            <input type="number" class="form-control" wire:model="commission" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Agent opérant</label>
                            <input type="text" class="form-control" wire:model="agent_operant" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="impot" id="impot">
                                <label class="form-check-label" for="impot">
                                    Accepter 
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary" wire:click="enregistrer_installation()">
                            <i class="bi bi-save me-2"></i>Enregistrer
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle me-2"></i>Fermer
            </button>
        </div>
    </div>

