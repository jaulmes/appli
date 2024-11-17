<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
//changement des couleur sur les boutton de filtre
    $(document).ready(function(){
        $('.btn').on('click', function(){
            //je retire la class active tu tout les bouttons
            $('.filtre').removeClass('active')
            //j'ajoute la classe active au boutton sur lequel j'ai clique
            $(this).addClass('active')
        })
    })

    //filtrer les ventes on fonction du statut
    $(document).ready(function(){
        $('.btn').on('click', function(){
            //je recupere la data de l'element
            let statut = $(this).data('statut')
            $.ajax({
                url: "{{ route('ventes.filtrer') }}",
                method: 'GET',
                data: {statut:statut},
                success: function(res){
                    $('#result').html(res)
                },        
                error: function() {
                    console.log('Erreur lors du chargement des données.');
                }
            })
        })
    })
</script>
<script>
    $(document).ready(function(){
        //filitrer les ventes en fonction des bouttons
        $('.btn').on('click', function(e){
            //je retire la class active
            $('.btn').removeClass('active')
            $(this).addClass('active')
        })

        //recherche des ventes effectue a l'aide de la barre de recherche
        $(document).on('keyup', function(e){
            e.preventDefault();
            let search = $('#search').val()

            $.ajax({
                url: "{{ route('ventes.rechercher') }}",
                method: 'GET',
                data: {search:search}, 
                success: function(res){
                    $('#result').html(res);
                },
                error: function() {
                    console.log('Erreur lors du chargement des données.');
                }
            })
        })
    });
    
</script>