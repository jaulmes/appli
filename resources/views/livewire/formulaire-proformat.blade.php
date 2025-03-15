<div>
    <div>
        <form id="formProformat" action="{{ route('panier.proformat') }}" method="post" >
            @csrf
            <div style="display: flex; flex-direction: row" id="clientExistantProformat">
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
                    <input type="button" class="btn btn-primary" id="nouveauClientProformat" value="Nouveau client?">
                </div>
            </div>
            <div id="nouveauClientFieldsProformat" style="display: none; flex-direction: row;">
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
                    <label for="reduction">Reduction</label>
                    <input class="form-control" type="number" name="reduction" id="reduction" required>
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

            <div class="form-group">
                <label for="impot">Accepter</label>
                <input type="checkbox" name="impot" id="impot">
            </div>
            <button type="submit" class="btn btn-primary" form="formProformat">Enregistrer</button>
        </form>
        <script>
            document.getElementById("nouveauClientProformat").addEventListener("click", function() {
                var clientFields = document.getElementById("nouveauClientFieldsProformat");
                var clientExistant = document.getElementById("clientExistantProformat");
                if (clientFields.style.display === "none") {
                    clientFields.style.display = "flex";
                    clientExistant.style.display = "none";
                } else {
                    clientFields.style.display = "none";
                }
            });
        </script>
    </div>
</div>
