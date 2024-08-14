<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $numeroFacture }} - {{$clients->numero}}</title>
    <style>
        body{
            margin-left: 0;
        }
        div.title{
            margin-left: 9em;
        }
        p.title{
            text-align: center;
            margin-bottom: -6em;
            font-size: 45px;
        }
        div.sous-title{
            display:flex;
            flex-direction: row;
            color: blue;
            margin-left: 0em;
            margin-top: -2.5em;
        }
        div.desc{
            margin-left: 0em;
            margin-right: 0em;
        }
        div.img{
            height: 50px;
            width: 50px;
        }
        div.contact{
            margin-left: 0em; 
            margin-top: -2em;
            font-family: serif;
            font-size: 12px;
        }
        .services {
            margin-top: 7em;
            margin-left: 1em;
            width: 60%;
        }
        .services table {
            width: 100%;
            border-collapse: collapse;
        }
        .services th, .services td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .total {
            margin-top: 20px;
        }
        div.content{
            background-image: url('logo.jpg');
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.5;
        }
        tr.hearder{
            background-color: rgb(192,192,192);
            Z-index: 5;
        }
    </style>
</head>
<body>
    <div class="title">
       <h1 style=" font-size:xxx-large; margin-bottom: -0.5em">
            S <img src="{{ asset('logo.jpg')}}" alt="" style="width: 35px; height: 30px"> LERGY_SOLUTIONS <br>
       </h1> 
        <p ><h4 style="margin-left: 11em; margin-top: -12em">SARL</h4></p>
    </div>
    <div class="sous-title" style="display:flex; flex-direction:row; margin-bottom: 3em; margin-top: -4.5em">
        <p>
            <div class="img1">
                <img src="{{asset('img3.jpg')}}" alt="" style="position: relative; height: 6em">
            </div>
            <div class="desc" style="margin-top: -10em; margin-left: 10em">
                <h3>
                    <strong style="font-family: 'Agency FB'; ">
                        Prestations de services, Installation solaire, <br>
                        Fourniture du matériel, Electricité bâtiment, <br >
                        <span style="margin-left: 4em;">
                            Domotique et systèmes 
                        </span>
                    </strong>
                </h3>
            </div>
            <div class="img2" style="margin-left:35em; margin-top: -15em" >
                <img src="{{asset('img7.jpg')}}" alt="" style="position: relative; height: 6em">
            </div>
        </p>
    </div>
    <div class="contact">
        <p style="margin-top: -0.5em;">
            <strong>NIU: M092316074072K</strong> <strong style="margin-left: 10em;">facebook : facebook/solergysolutions</strong> <strong style="margin-left: 8em;">Contacts : 6 57 24 89 25</strong>
        </p>
        <p style="margin-top: -0.5em;">
            <strong>Code marchand {{ $ventes->compte->nom}} : {{ $ventes->compte->numero}}</strong>  <strong style="margin-left: 24em;">Email :solutionssolergy@gmail.com</strong>
        </p>
        <div style="margin-top: -1em;">
            <p>
                <strong>REF : {{ $numeroFacture }}</strong>  
                <strong style="margin-left: 38em;">date: {{ $ventes->date}}</strong>
            </p>
            <div style="display: flex;">
                <div>
                    <strong>Agent opérant : @auth {{ Auth::User()->name}}  @endauth</strong> <br> 
                    <strong>TEL : @auth {{ Auth::User()->numero}}  @endauth</strong>
                </div>
                <div style="margin-left: 48em; margin-top:-5em">
                    <strong><h3>client : {{$clients->nom}}</h3></strong> <br>
                    <strong><h3>TEL: {{$clients->numero}}</h3></strong>
                </div>
            </div>
        </div>
    </div>
    
    <div style="margin-top: -2em">
        <p class="title">
            <u>
                facture de vente
            </u>
        </p>
    </div>
    <div class="content">
        <div class="services">
            <table style=" width: 40em;   border-style: solid; border-color: black;">
                <tr class="hearder">
                    <th>Qté</th>
                    <th>Désignation</th>
                    <th>P.U.</th>
                    <th>P.Total</th>
                </tr>
                @php
                    $total = 0;
                @endphp
                @foreach(Cart::getContent() as $produit)
                @php
                    $total += $produit->price * $produit->quantity;
                @endphp
                <tr>
                    <td>{{$produit->quantity}}</td>
                    <td>{{$produit->name}}</td>
                    <td>{{$produit->price}}</td>
                    <td>{{$produit->price * $produit->quantity}}</td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                    <td><strong>{{ $total }}</strong></td>
                </tr>
            </table>
        </div>
        <div class="footer" style="text-align:center">
            <div class="total"> 
                <strong style="margin-bottom: 3em; Z-index: 5; background-color:grey; color: black !important"> Arrêtée la présente facture à la somme de : <strong>{{ $ventes->montantVerse}} Francs CFA</strong> </strong>
            </div>
            <div style="margin-left: 20em; margin-top: 4em">Signature Client </div>
            <div style=" margin-left: -35em">Signature Vendeur</div>
        </div>
    </div>
</body>
</html>