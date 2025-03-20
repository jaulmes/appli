<div>
    <form id="formVente" action="{{ route('panier.enregistrer') }}" method="post" style="display: none;">
        @csrf
        <div style="display: flex; flex-direction: row" id="clientExistant">
            <div class="form-group">
                Client
                <select class="form-control" name="client_id" >
                    <option selected disabled>choix du Client...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input type="button" class="btn btn-primary" id="toggleClient" value="Nouveau client?">
            </div>
        </div>
        <div id="nouveauClientFields" style="display: none; flex-direction: row;">
            <div class="form-group">
                <label for="nom">Nom du client</label>
                <input class="form-control" type="text" name="nom" id="nom" >
            </div>
            <div class="form-group">
                <label for="numero">Numéro du client</label>
                <input class="form-control" type="number" name="numero" id="numero" >
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
        @if(\Cart::getTotal() > 50000)
            <div style="display: flex; flex-direction: row">
                <div class="form-group">
                    <label for="commission">commission</label>
                    <input class="form-control" type="number" name="commission" id="commission" required>
                </div>
                <div class="form-group">
                    <label for="agentOperant">Agent Operant</label>
                    <input class="form-control" type="text" name="agentOperant" id="agentOperant" required>
                </div>
            </div>
        @endif
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
        <button type="submit" class="btn btn-primary" >Enregistrer</button>
    </form>
    <script>
        document.getElementById("toggleClient").addEventListener("click", function() {
            var clientFields = document.getElementById("nouveauClientFields");
            var clientExistant = document.getElementById("clientExistant");
            if (clientFields.style.display === "none") {
                clientFields.style.display = "flex";
                clientExistant.style.display = "none";
            } else {
                clientFields.style.display = "none";
            }
        });
    </script>
</div>