@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
    <div class="container h-100 py-5">
        <div class="col">
            <div style="margin-left: 15em; height: 4em">
                <form action="{{ route('panier.index') }}" method="get">
                    <input type="text" placeholder="chercher un produit..." name="q" />
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="table-responsive" style="display: flex; flex-direction: row">
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="row row-cols-1 row-cols-md-3 g-3">
                            @foreach($produits as $produit)
                            <div class="col" style="margin-bottom: 20px; margin-left: 5px; margin-right: -5em;">
                                <div class="row" data-aos="fade-left">
                                    <div class="col-lg-10 col-md-6">
                                        <div class="card h-80" style="width:9em;">
                                            <strong class="badge badge-danger">{{ $produit->getAlert() }}</strong>
                                            @if($produit->getStock() === "disponible")
                                            <strong class="badge badge-info">{{ $produit->getStock() }}</strong>
                                            @endif
                                            @if($produit->getStock() === "indisponible")
                                            <strong class="badge badge-danger">{{ $produit->getStock() }}</strong>
                                            @endif
                                            <img src="{{ asset('storage/images/produits/'.$produit->image_produit) ?? 'bjr' }}" class="img-fluid" alt="" style="height: 5em; width: 100%">
                                            <div class="member-info" style="font-size: 12px;">
                                                <h7 style="margin-bottom: -0.1em;"><u>Nom</u>: {{ $produit->name }}</h7>
                                                <p class="card-text" style="margin-bottom: -0.1em;"><u>Desc</u>: {{ $produit->getDescription() }}</p>
                                                <p class="card-text" style="margin-bottom: -0.1em;"><u>Prix</u>: <strong style="background-color:green">{{ $produit->getPrice() }}</strong></p>
                                                <div class="row" style="margin-left: 0.2em; padding-bottom: 0.01em; margin-top: 0.5em;">
                                                    <a href="{{ route('produit.detail', $produit->id) }}">
                                                        <button class="btn btn-warning px-1"><i class="bi bi-eye"></i></button>
                                                    </a>
                                                    @if($produit->getStock() === "disponible")
                                                    <form action="{{ route('achats.storeCart') }}" method="post">
                                                        @csrf
                                                        <div class="action">
                                                            <input type="hidden" name="id" value="{{ $produit->id }}">
                                                            <input type="hidden" name="name" value="{{ $produit->name }}">
                                                            <input type="hidden" name="price" value="{{ $produit->price }}">
                                                            <button class="add-to-cart btn btn-primary px-1" type="submit" style="margin-left: 2em; margin-top:-3.5em"><i class="bi bi-plus"></i></button>
                                                        </div>
                                                    </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div style="">
                    <div class="card-body p-4">
                        <div class="row card shadow-2-strong mb-lg-0" id="monPanier" style="position: fixed; width: 25em; padding-bottom: 3em; padding-top: 3em; margin-top: -7em; margin-left: -20em; font-size:12px ">
                            <h6><strong><u>Mon panier</u></strong></h6><br>
                            <table class="table table-responsive" style="overflow-y: visible;">
                                <thead>
                                    <tr>
                                        <th scope="col" class="h6">Nom</th>
                                        <th scope="col">P U</th>
                                        <th scope="col">QTE</th>
                                        <th scope="col">Prix T</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="card-body table-responsive p-0" style="height: 200px;">
                                    @foreach( Cart::getContent() as $produit)
                                    <tr>
                                        <th scope="row">
                                            <p class="mb-2">{{ $produit->name }}</p>
                                        </th>
                                        <th class="align-middle">
                                            <p class="mb-0" style="font-weight: 500;">{{ $produit->price }}</p>
                                        </th>
                                        <th class="align-middle">
                                            <p class="mb-0" style="font-weight: 500;">{{ $produit->quantity }}</p>
                                        </th>
                                        <th class="align-middle">
                                            <p class="mb-0" style="font-weight: 500;">{{ $produit->price * $produit->quantity }}</p>
                                        </th>
                                        <th>
                                            <form action="{{ route('produit.retirer', $produit->id) }}" method="get">
                                                @csrf
                                                <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </th>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col-lg-4 col-xl-3">
                                <div class="d-flex justify-content-between" style="font-weight: 500;">
                                    <p class="mb-2">total: </p>
                                    <p class="mb-2" style="margin-left: 10em;">{{ Cart::getTotal() }}</p>
                                </div>
                            </div>
                            <form action="{{ url('detruire') }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-danger" style="width: 8em; font-size:10px">vider le panier</button>
                            </form>
                            <button type="button" style="width: 8em; margin-left:10em; margin-top:-4.7em; font-size:10px" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Valider l'achat</button>
                        </div>
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enregistrement de la transaction. prix des produits: {{ Cart::getTotal() }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row" style="display: flex; flex-direction:column">
                                                <label><input type="radio" name="option" value="yes"> Vente de produit</label>
                                                <label><input type="radio" name="option" value="no"> Installation</label>
                                            </div>
                                            
                                            <!-- Formulaire vente de produit-->
                                            <form id="formYes" action="{{ route('panier.enregistrer') }}" method="post" style="display: none;">
                                                @csrf
                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                        <label for="nom">Nom du client</label>
                                                        <input class="form-control" type="text" name="nom" id="nom" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="numero">Numéro du client</label>
                                                        <input class="form-control" type="number" name="numero" id="numero" required>
                                                    </div>
                                                </div>
                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                        <label for="montantVerse">Montant versé</label>
                                                        <input class="form-control" type="number" name="montantVerse" id="montantVerse" value="{{ Cart::getTotal() }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="reduction">Reduction</label>
                                                        <input class="form-control" type="number" name="Reduction" id="reduction" required>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    Mode de paiement...
                                                    <select class="form-control" name="modePaiement" required>
                                                        <option selected disabled>choix Mode de paiement...</option>
                                                        @foreach($comptes as $compte)
                                                        <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            
                                                <div class="form-group">
                                                    <label for="impot">Accepter</label>
                                                    <input type="checkbox" name="impot" id="impot">
                                                </div>
                                                <button type="submit" class="btn btn-primary" form="formYes">Enregistrer</button>
                                            </form>
                                            
                                            
                                            <!-- Formulaire installation sollaire -->
                                            <form id="formNo" action="{{ route('panier.installation')}}"  method="post" style="display: none;">
                                                @csrf
                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                        <label for="nom">Nom du client</label>
                                                        <input class="form-control" type="text" name="nom" id="nom" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="numero">Numéro du client</label>
                                                        <input class="form-control" type="number" name="numero" id="numero" required>
                                                    </div>
                                                </div>

                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                        <label for="agentOperant">Agent operant</label>
                                                        <input class="form-control" type="text" name="agentOperant" id="agentOperant" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Commission">Commission</label>
                                                        <input class="form-control" type="number" name="Commission" id="Commission"  required>
                                                    </div>
                                                </div>
                                                
                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                        <label for="montantProduit">Prix des produits</label>
                                                        <input class="form-control" type="number" name="montantProduit" id="montantProduit" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="mainOeuvre">Installation</label>
                                                        <input class="form-control" type="number" name="mainOeuvre" id="mainOeuvre"  required>
                                                    </div>
                                                </div>
                                                
                                                <div style="display: flex; flex-direction: row">
                                                    <div class="form-group">
                                                            <label for="montantVerse">Montant verse</label>
                                                            <input class="form-control" type="number" name="montantVerse" id="montantVerse" required>
                                                    </div>
                                                        
                                                    <div class="form-group">
                                                        <label for="reduction">Reduction</label>
                                                        <input class="form-control" type="number" name="Reduction" id="reduction" required>
                                                    </div>
                                                </div>
                                                
                                                    <div class="form-group">
                                                        choix du mode de paiement...
                                                        <select class="form-control" name="modePaiement" required>
                                                            <option selected disabled>choix Mode de paiement...</option>
                                                            @foreach($comptes as $compte)
                                                            <option value="{{ $compte->id }}">{{ $compte->nom }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                
                                                <button type="submit" class="btn btn-primary" form="formNo">Enregistrer</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Fin du modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name="option"]');
        const formYes = document.getElementById('formYes');
        const formNo = document.getElementById('formNo');
        
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'yes') {
                    formYes.style.display = 'block';
                    formNo.style.display = 'none';
                } else if (this.value === 'no') {
                    formYes.style.display = 'none';
                    formNo.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection
