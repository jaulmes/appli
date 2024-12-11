<div>
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
                <input class="form-control" type="number" name="commission" id="Commission"  required>
            </div>
        </div>
        
        <div style="display: flex; flex-direction: row">
            <div class="form-group">
                <label for="montantProduit">Prix des produits</label>
                <input class="form-control" type="number" name="montantProduit" id="montantProduit" value="{{\Cart::getTotal()}}" required>
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
                <input class="form-control" type="number" name="reduction" id="reduction" required>
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
