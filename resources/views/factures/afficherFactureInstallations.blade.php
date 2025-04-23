<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $factures->numeroFacture }} - {{$installations->numeroClient ?? $installations->clients->numero?? 'FACTURE INSTALLATION'}}</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
      

        .company-info .title{
          margin-bottom: 0em;
          font: italic small-caps bold 12px/30px Verdana;
          font-weight: bold;
          margin-top: -2em;
          margin-left: 5em;

        }

        .description{
            font-size: 20px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            font-weight: bold;
            margin-left: 5em;
            font: italic small-caps bold  Verdana;
        }

        .company-info p span.solergy {
            font-size: 5.1em; /* Adjusted company name size */
            color:rgba(26, 36, 150, 0.58);
            margin-bottom: 2px; /* Reduced margin */
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1; /* Tighter line height */
            font-family: 'Roboto', sans-serif;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        .company-info p span.solution {
            font-size: 3em; /* Adjusted company name size */
            color:rgb(80, 211, 80);
            margin-bottom: 2px; 
            margin-left: 5em;
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1; /* Tighter line height */
        }

        .company-info p span.sarl {
            font-size: 2.5em; /* Adjusted company name size */
            
            margin-bottom: 2px; /* Reduced margin */
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1; /* Tighter line height */
        }

        .company-info h1 span {
            color: #90EE90; /* Light green for SOLERGY */
        }

        .company-info p {
            font-size: 1.1em; /* Adjusted slogan size */
            margin: 0;
            font-style: italic;
        }

        /* NIU, Contacts, RCCM */
        .header-details {
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
            font-size: 0.7em;
            font: italic small-caps bold 12px/30px Verdana;
        }
        .header-details .left {
            position: absolute;
            flex: 1;
            margin-top: 1em;
            text-align: left;
        }
        .header-details .center {
            margin-top: 1em;
            margin-left: -3em;
            flex: 1;
            text-align: center;
        }
        .header-details .right {
            flex: 1;
            text-align: right;
            margin-top: -2.5em;
        }

        /* Ref and Facture Proforma */
        .ref-proforma {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            margin-top: 1em;
        }
        .ref-proforma .ref {
            font-weight: bold;
            font-size: 0.7em;
        }
        .ref-proforma .proforma-title {
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
            position: absolute;
            margin-left: 7.5em;
            margin-top: -0.7em;
        }

        /* Agent Operant */
        .agent-operant {
            text-align: right;
            font-size: 0.7em;
            margin-top: -1em;
        }

        /* Client Information */
        .client-info {
            border: 1px dashed #ccc;
            margin-bottom: 25px;
            font-size: 1.2em;
        }

        .client-info-title {
            font-weight: bold;
            margin-bottom: 2em;
            font-size: 0.5em;
            text-align: center;
        }

        .client-details-row {
            display: flex;
            justify-content: flex-start; /* Align items to the start horizontally */
            align-items: flex-start; /* Align items to the top vertically */
            font: italic  Verdana;
            font-size: 0.5em;
        }

        .client-nom { /* Columns for client details */
            flex: 1;
            margin-left: 2em;
        }

        .client-contact{
            text-align: center;
            margin-top: -3em;
        }

        .client-adresse{
            font-size: 0.95em;
            text-align: right;
            margin-top: -3em;
            margin-right: 5em;
        }
        .client-details-col p:first-child { /* Style for "NOM du client" etc. labels */
            font-weight: bold;
            margin-right: 1em; /* Add space after label */
        }

        /* Image Placeholder */
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
            margin-top: -8em;
        }

        /* Footer Section */
        .invoice-footer {
        position: fixed; 
        bottom: 0px;
        left: 0px; 
        right: 0px; 
        margin-top: 17em;
        }
        @page{
            margin-bottom: 0.5em; 
        }

        .footer-details {
            display: flex;
            gap: 15px;
            margin-bottom: 8px;
            position: absolute;
            font-size: 10px;
        }
        .footer-details p {
            margin: 0;
            flex-direction: column;
        }

        .address-footer {
            font-size: 0.9em;
            text-align: center;
        }


        /* Dotted Line Separator (if needed) */
        .dotted-line {
            border-bottom: 1px dotted #ccc;
            margin: 10px 0; /* Adjust spacing */
        }
         .separator {
            margin-top: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #000; /* Solid black line */
        }
        div.content{
            background-image: url('logo.jpg');
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.5;
        }


    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="invoice-header">
            <div class="company-info">
              <div class="title">
                <strong>
                    <p><span class="solergy">S<img src="{{ public_path('logo.jpg')}}" alt="" style="width: 70px; height: 65px">LERGY</span> <br> <span class="solution">SOLUTIONS SARL</span></p>
                </strong>
              </div>
              <div class="description">
                <p>Fournisseur de solutions solaire</p>
              </div>
            </div>
        </header>

        <div class="header-details">
            <div class="left">NIU: M092316074072K</div>
            <div class="center">Contacts:(+237) 6 57 24 89 25 – 6 78 64 51 11 – 6 21 30 99 00</div>
            <div class="right">No RCCM: RC/DLA/2023/B/5907</div>
        </div>

        <div class="ref-proforma">
            <div class="ref">REF: {{ $factures->numeroFacture }}</div>
            <h2 class="proforma-title">FACTURE INSTALLATIONS</h2>
            <div class="agent-operant">Agent opérant: <strong>{{ $installations->user->name ?? $installations->agentOperant?? '-'}}</strong> </div>
            <div class="agent-operant" style="margin-top: 1em;">Date: <strong>{{ $installations->created_at->format('d-m-y')}}</strong> </div>
        </div>

        <div class="separator"></div>

        <section class="client-info">
            <h3 class="client-info-title">Coordonnées du client :</h3>
            <div class="client-details-row">
                <div class="client-nom">
                    <p>NOM du client : <strong>{{ $installations->clients->nom?? $installations->commandes->clients->nom?? '-'}} </strong> </p>
                </div>
                <div class="client-contact">
                    <p>Contacts : <strong> {{$installations->clients->numero?? $installations->commandes->clients->numero?? '-'}}</strong></p>
                </div>
                <div class="client-adresse">
                    <p>Adresse : <strong>{{$installations->clients->adresse?? $installations->commandes->clients->adresse?? '-'}}</strong> </p>
                </div>
            </div>
        </section>

        <div class="content">
            <div class="services">
                <table style=" width: 40em;   border-style: solid; border-color: black;">
                    <tr class="hearder">
                        <th>Qté</th>
                        <th>Désignation</th>
                        <th>P.U.</th>
                        <th>P.Total</th>
                    </tr>

                    <!--produits achetes-->
                    @foreach($installations->produits as $produit)
                        <tr>
                            <td>{{$produit->pivot->quantity}}</td>
                            <td>{{$produit->name}}</td>
                            <td>{{$produit->pivot->price}}</td>
                            <td>{{$produit->pivot->quantity * $produit->pivot->price}}</td>
                        </tr>
                    @endforeach
                    <tr >
                        <td colspan="3" style="text-align: center;">Installation</td>
                        <td><strong>{{ $installations->mainOeuvre }}</strong></td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                        <td><strong>{{ $installations->montantProduit + $installations->mainOeuvre }}</strong></td>
                    </tr>
                </table>
            </div>
            <div class="mini-footer" style="text-align:center">
                @if($installations->reduction > 0)
                    <div class="total"> 
                        <span style="margin-bottom: 3em; Z-index: 5; background-color:grey; color: black !important"> la reduction sur votre facture est de : <strong>{{ $installations->reduction}} Francs CFA</strong> </span>
                    </div>
                @endif
                <div class="total"> 
                    <span style="margin-bottom: 3em; Z-index: 5; background-color:grey; color: black !important; margin-left: 25em;"> Net A Payer <strong style="color: #27ae60; background-color: #e9f7ef;"> <u>{{ $installations->NetAPayer}} Francs CFA</u> </strong> </span>
                </div>
                
                <div style="position: absolute; margin-left: 5em; ">Signature Client   </div>
                <div style="margin-left: 10em ">Signature Vendeur</div>
            </div>
        </div>


    </div>
    <footer class="invoice-footer">
        <div class="footer-details">
            <p class="site-web">Site web: solergy-solutions.com</p>
            <p class="facebook" style="margin-left: 15em; margin-top: -3em">Facebook/Solergysolutions</p>
            <p class="uba"style="margin-left: 28em; margin-top: -3em">COMPTE UBA No: 9011000973;</p>
            <p style="margin-left: 45em; margin-top: -3em">CODE MARCHAND: #150*47*800889#</p>
        </div>
        <p class="address-footer" style="margin-top: 20px;">Situé à douala en face de l'entrée du collège Bénédicte sur l'axe Tradex Ndokoti-total BP cité</p>
    </footer>
</body>
</html>