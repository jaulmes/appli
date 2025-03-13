<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FACTURE PROFORMA</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 11px; /* Slightly smaller base font */
            line-height: 1.3;
        }

        .invoice-container {
            width: 750px; /* Adjust width to match document width */
            margin: 0 auto;
            /* border: 1px solid #ddd;  Optional border for visualization */
            padding: 25px 30px; /* Adjust padding for document margins */
        }

      

        .company-info {
            text-align: center;
            margin-top: -4em;
            margin-left: -15em;
        }
        .company-info .title{
          margin-bottom: 3em;
        }

        .description{
          font-size: 36px;
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            font-weight: bold;
        }

        .company-info p span.solergy {
            font-size: 4.1em; /* Adjusted company name size */
            color: #90EE90;
            margin-bottom: 2px; /* Reduced margin */
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1; /* Tighter line height */
        }

        .company-info p span.solution {
            font-size: 2.3em; /* Adjusted company name size */
            color: #007bff;
            margin-bottom: 2px; /* Reduced margin */
            font-weight: bold;
            letter-spacing: -1px;
            line-height: 1; /* Tighter line height */
        }

        .company-info p span.sarl {
            font-size: 1.3em; /* Adjusted company name size */
            color: #90EE90;
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
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9em;
        }
        .header-details > div { /* Direct children divs */
            flex: 1; /* Distribute space evenly */
        }
        .header-details .left {
            text-align: left;
        }
        .header-details .center {
            text-align: center;
        }
        .header-details .right {
            text-align: right;
        }

        /* Ref and Facture Proforma */
        .ref-proforma {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .ref-proforma .ref {
            font-weight: bold;
            font-size: 1em;
        }
        .ref-proforma .proforma-title {
            text-align: center;
            font-size: 2.3em; /* Adjusted title size */
            font-weight: bold;
            letter-spacing: -2px;
            margin-bottom: 0; /* Remove bottom margin */
            line-height: 1; /* Tighter line height */
        }

        /* Agent Operant */
        .agent-operant {
            text-align: right;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        /* Client Information */
        .client-info {
            border: 1px solid #ccc;
            padding: 10px 15px;
            margin-bottom: 25px;
        }

        .client-info-title {
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 1em;
        }

        .client-details-row {
            display: flex;
            justify-content: flex-start; /* Align items to the start horizontally */
            align-items: flex-start; /* Align items to the top vertically */
            gap: 40px; /* Spacing between client details */
        }

        .client-details-col { /* Columns for client details */
            flex: 1; /* Allow columns to take up available space */
        }

        .client-details-col p {
            margin: 4px 0;
            font-size: 0.95em;
        }
        .client-details-col p:first-child { /* Style for "NOM du client" etc. labels */
            font-weight: bold;
            margin-right: 5px; /* Add space after label */
        }

        /* Image Placeholder */
        .image-placeholder {
            height: 280px; /* Adjust height as needed */
            border: 1px dashed #ccc;
            margin-bottom: 25px;
            text-align: center;
            line-height: 280px;
            color: #999;
            font-size: 1.2em;
        }

        /* Footer Section */
        .invoice-footer {
            text-align: center;
            font-size: 0.8em;
            color: #555;
            margin-top: 20px;
        }

        .footer-details {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 8px;
        }
        .footer-details p {
            margin: 0;
        }

        .address-footer {
            font-size: 0.9em;
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
    </style>
</head>
<body>
    <div class="invoice-container">
        <header class="invoice-header">
            <div class="company-info">
              <div class="title">
                <p><span class="solergy">SOLERGY</span> <span class="solution">SOLUTIONS</span> <span class="sarl">SARL</span></p>
              </div>
              <div class="description">
                <p>Votre fournisseur de solutions solaire</p>
              </div>
            </div>
        </header>

        <div class="header-details">
            <div class="left">NIU: M092316074072K</div>
            <div class="center">Contacts:(+237) 6 57 24 89 25 – 6 78 64 51 11 – 6 21 30 99 00</div>
            <div class="right">No RCCM: RC/DLA/2023/B/5907</div>
        </div>
        <div class="separator"></div>

        <div class="ref-proforma">
            <div class="ref">REF: CA_DLA_MAR_25_2</div>
            <h2 class="proforma-title">FACTURE PROFORMA</h2>
        </div>


        <div class="agent-operant">Agent opérant: ASSONKENG CABREL</div>

        <section class="client-info">
            <h3 class="client-info-title">Coordonnées du client :</h3>
            <div class="client-details-row">
                <div class="client-details-col">
                    <p>NOM du client : Mme</p>
                </div>
                <div class="client-details-col">
                    <p>Contacts : 6 98 33 39 95 - 6</p>
                </div>
                <div class="client-details-col">
                    <p>Adresse : BOMONO</p>
                </div>
            </div>
        </section>

        <!-- Image Placeholder -->
        <div class="image-placeholder">
            [Image Placeholder]
        </div>

        <footer class="invoice-footer">
            <p>SOLERGY SOLUTIONS SARL</p>
            <div class="footer-details">
                <p>Site web: solergy-solutions.com</p>
                <p>Facebook/Solergysolutions</p>
                <p>COMPTE UBA No: 9011000973;</p>
                <p>CODE MARCHAND: #150*47*800889#</p>
            </div>
            <p class="address-footer">Situé à douala en face de l'entrée du collège Bénédicte sur l'axe Tradex Ndokoti-total BP cité</p>
        </footer>
    </div>
</body>
</html>