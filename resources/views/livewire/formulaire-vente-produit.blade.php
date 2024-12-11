<div>
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
                <input class="form-control" type="number" name="reduction" id="reduction" required>
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
</div>