<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de paiement - </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 148mm; /* Largeur d'un A5 */
            margin: 10px;
            padding: 10px;
            border: 1px solid black;
        }
        .header, .footer {
            text-align: center;
            font-size: 14px;
        }
        .header img {
            width: 50px;
            height: auto;
        }
        .content {
            margin-top: 10px;
            background-image: url('logo.jpg');
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.5;
        }
        .info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 10px;
        }
        .table-container {
            width: 100%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
        }
        .total {
            text-align: right;
            margin-top: 10px;
            font-size: 14px;
        }
        .signatures {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>S<img src="{{ asset('logo2.jpg')}}" alt="" style="width: 25px; height: 20px">lergy Solutions SARL</h2>
        <div class="row">
            <div class="row">
                <div class="img1" >
                    <img src="{{asset('img3.jpg')}}" alt="" style="position: absolute; height: 6em; margin-left: -17em; margin-top: -3em">
                </div>
            </div>
            <div class="description row">
                <strong style="font-family: 'Agency FB'; ">
                    Prestations de services, Installation solaire, <br>
                    Fourniture du matériel, Electricité bâtiment, <br >
                    <span style="margin-left: 4em;">
                        Domotique et systèmes 
                    </span>
                </strong>
            </div>
            <div class="row">
                <div class="img2" style="margin-left:35em; margin-top: -5em" >
                    <img src="{{asset('img7.jpg')}}" alt="" style="position: relative; height: 6em">
                </div>
            </div>
            
            <p><strong>Reçu de paiement</strong></p>
        </div>
    </div>
    
    <div class="content">
        <div class="info">
            <div>
                <p><strong>Référence :</strong> </p>
                <p><strong>Date :</strong> </p>
            </div>
            <div>
                <p><strong>Client :</strong> </p>
                <p><strong>Téléphone :</strong> </p>
            </div>
        </div>

        <div class="table-container">
            <table>
                <tr>
                    <th>Qté</th>
                    <th>Désignation</th>
                    <th>P.U.</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total</strong></td>
                    <td><strong> CFA</strong></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Net à payer</strong></td>
                    <td><strong style="color: green;"> CFA</strong></td>
                </tr>
            </table>
        </div>

        <div class="signatures">
            <div>
                <p>Signature Client</p>
                <br><br>
                <hr>
            </div>
            <div>
                <p>Signature Vendeur</p>
                <br><br>
                <hr>
            </div>
        </div>
    </div>
</body>
</html>
