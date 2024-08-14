@extends('dashboard.main')

@section('extra-meta')

@endsection
    <meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<h2>Acheter des produits</h2>

<div class="form-group" style="width: 50em; margin-left: 2em">
    <form action="{{ route('achats.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Categorie</label>
            <select class="form-select form-control" name="categori_id"  data-placeholder="Select a State"  id="categori_id">
                <option selected disabled> choisir la categorie</option>
            @foreach($categoris as $categori)
                <option value="{{ $categori->id }}" data-categori_id="{{ $categori->id }}">{{ $categori->titre }}</option>
            @endforeach
            </select>
        </div>
        <div class="col-md-5">
            <label class="small my-1" for="product_id">Produit <span class="text-danger">*</span></label>
            <select class="form-select form-control" id="produit_id" name="produit_id">
                <option disabled>Choisir le produit:</option>
            </select>
        </div>
            <button id="ajouter-produit" type="button" class="btn btn-primary">Ajouter le produit</button>

            <div class="gx-3 table-responsive">
                            <table id="tableau-produits"  class="table align-middle">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Quantité</th>
                                        <th>prix</th>
                                        <th>Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody  class="addRow">

                                </tbody>

                                <tbody>
                                    <tr class="table-primary">
                                        <td colspan="3"></td>
                                        <td>
                                            <input type="text" name="total_amount" value="0" id="total_amount" class="form-control total_amount" readonly>
                                            <input type="number" name="compteur" data-quantite_total="0" id="compteur">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-outline-success" onclick="return confirm('Are you sure you want to purchase?')">
                                                Enregistrer l'Achat
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

    </form>
</div>

@endsection

@section('javascript')

<script src="{{asset('jquery-3.7.1.js')}}">
  
$('select[multiple]').multiselect({
    columns  : 2,
    search   : true,
    selectAll: true,
    texts    : {
        placeholder: 'Select Languages',
    }
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    var compteur = 0
    var compteurProduit = document.getElementById('compteur')

    $('#ajouter-produit').click(function() {

                var produit_id = $('#produit_id').val();
                var produit_nom = $('#produit_id option:selected').text();
                var test = $('#compteur')
                if (produit_id) {
                    compteur++
                    compteurProduit.value=compteur;
                    console.log(compteur);
                    console.log(compteurProduit.value);
                    $(".addRow")
                        .append(`
                        <tr>
                            <th>
                                <label for='${produit_nom}'> ${produit_nom} </label> 
                                <input id='${produit_nom}' name="produit_id[]" value='${produit_id}' type='hidden'>
                            </th>
                            <th>
                                <input  name="quantite[]"  >
                            </th>
                            <th>
                                <input  name="prixUnitaire[]"  >
                            </th>
                        </tr>
                                
                                `)

                }
                

            });
            $.each('#ajouter-produit').click(function(){
                var produit_id = $('#produit_id').val();
                var conteur = 0
                if(produit_id){
                    conteur++
                }
                console.log(conteur)
            })

            // function afficherProduits() {
            //     $('#tableau-produits tbody').empty();
            //     $.each(produitsSelectionnes, function(index, produit) {
            //         $('#tableau-produits tbody').append('<tr><td>' + produit.name + '</td></tr>');
            //     });
            // }



})

</script>

<!-- recuperer et afficher les produit lies aux categorie -->

<script type="text/javascript">
    $(document).ready(function(){
        $("#categori_id").on('change', function(){
            let categori_id = $(this).val();
            $.ajax({
                url: "{{route('achats.produit')}}",
                type: 'GET',
                data: {categori_id: categori_id},
                success:function(data){
                    var productSelect = $('#produit_id');
                    productSelect.empty(); // Videz le select existant
                    $.each(data, function(index, product) {
                        productSelect.append($('<option>', {
                            value: product.id,
                            text: product.name
                }));
            });

                    }
            })
        })
    })


</script>

@endsection