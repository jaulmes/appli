<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
      body{
        background-color: #f5f5dc;
        padding-left: 1em;
        padding-right: 1em;
        font-size: small;

      }
      .header{
        display: flex;
        flex-direction: row;
      }
      .logo{
        height: 50px;
        width: 50px;
        margin-left: 2em;
      }
      .entete{
        display: flex;
        flex-direction: row;
      }
      #content{
        display: flex;
        background-image: url('logo.jpg');
        background-repeat: no-repeat;
        background-position: center;
        opacity: 0.8;
      }
      #montant{
        flex-direction: row;
        margin-left: 22em;
        margin-top: -9em;
      }
      @page {
          margin: 0;
      }
    </style>
</head>
<body>
  <div class="header row">
    <div class="title col">
      <h4>Recu de versement d'argent</h4>
    </div>
    <div  style="margin-left: 25em; margin-top: -2em; background-color: white; border-radius: 5px; font-size: small; padding: 2px; width: 14em;">
      No de Recu: {{$recus->numero_recu}}
    </div>
    <div style="margin-left: 25em; margin-top: 0em; position: absolute;">
      <p>Date de remise du recu: <Strong style="background-color: white;">{{$recus->created_at->format('d-m-Y')}}</Strong></p>
    </div>
  </div>
  <div class="entete" >
    <div class="logo col">
      <img src="{{public_path('logo.jpg')}}" class="logo" alt="">
    </div>
  </div>
  <hr>
  <div id="content" >
    <div class="client">
      <p>Nom du client: <strong style="background-color: white;">{{$recus->installations->clients->nom}}</strong> F CFA</p>
      <p>Numero du client: <strong style="background-color: white;">{{$recus->installations->clients->numero}}</strong>F CFA</p>
      <p>Motif: <strong style="background-color: white;">345678</strong>F CFA</p>
    </div>
    <div id="montant" >
      <p><strong>Montant versé:</strong> <strong style="background-color: white; margin-left: 4em;">{{$recus->montant_recu}} </strong>F CFA</p>
      <p><strong>Dette Precedente:</strong>  <strong style="background-color: white; margin-left: 3em;">{{$recus->installations->NetAPayer - $recus->installations->montantVerse}} </strong>F CFA</p>
      <p><strong>Dette Restante:</strong> <strong style="background-color: white; margin-left: 4em;">{{$recus->installations->NetAPayer - ($recus->installations->montantVerse - $recus->montant_recu)}} </strong>F CFA</p>
      <p><strong>Date limite de paiement:</strong> <strong style="background-color: white;">345678 </strong>F CFA</p>
    </div>
  </div>
  <hr>
  <div  style="font-size: 8px; text-align: center">
    <span>DOUALA, EN FACE DE L'ENTRÉE COLLÈGE BÉNÉDICTE SUR L'AXE TRADEX NDOKOTTI - TOTAL BP SITEE; </span>
    <span>NIU:  M092316074072K; </span><br>
    <span style="font-size: xx-small;">No RCCM:  RC/DLA/2023/B/5907; </span>
    <span >Solergy Solution Sarl - solergy-solution.com </span>
    <span > +237 657 248 925</span>
  </div>
</body>
</html>