<div>
    <form id="formInstallation" action="{{ route('panier.installation')}}"  method="post" style="display: none;">
        @csrf
        <div style="display: flex; flex-direction: row" id="clientPresent">
            <div class="form-group">
                Client
                <select class="form-control" name="client_id">
                    <option selected disabled>Choix du Client...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="button" id="afficherFormulaire" value="Nouveau client ?">
            </div>
        </div>

        <!-- Champs cachés au départ -->
        <div id="nouveauClient" style="display: none; flex-direction: row;">
            <div class="form-group">
                <label for="nom">Nom du client</label>
                <input class="form-control" type="text" name="nom" id="nom">
            </div>
            <div class="form-group">
                <label for="numero">Numéro du client</label>
                <input class="form-control" type="number" name="numero" id="numero">
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
    <script>
    document.getElementById("afficherFormulaire").addEventListener("click", function() {
        var nouveauClientFields = document.getElementById("nouveauClient");
        var clientPresent = document.getElementById("clientPresent");

        if (nouveauClientFields.style.display === "none") {
            nouveauClientFields.style.display = "flex";
            clientPresent.style.display = "none"; // Masquer la sélection de client existant
        } else {
            nouveauClientFields.style.display = "none";
            clientPresent.style.display = "flex"; // Réafficher la sélection de client existant
        }
    });
</script>
</div>
