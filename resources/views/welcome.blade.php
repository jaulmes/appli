<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        tfoot td {
            font-weight: bold;
        }
    </style>
    @livewireStyles
</head>
<body>

<?php
// Exemple de données des produits provenant de la base de données
$produits = [
    ['nom' => 'Produit 1', 'quantite' => 2, 'prix_unitaire' => 100],
    ['nom' => 'Produit 2', 'quantite' => 1, 'prix_unitaire' => 200],
    ['nom' => 'Produit 3', 'quantite' => 3, 'prix_unitaire' => 150],
];

$totalFacture = 0;
?>

<table>
    <thead>
        <tr>
            <th>Nom du produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Montant</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($produits as $produit): 
            $montant = $produit['quantite'] * $produit['prix_unitaire'];
            $totalFacture += $montant;
        ?>
            <tr>
                <td><?php echo htmlspecialchars($produit['nom']); ?></td>
                <td><?php echo htmlspecialchars($produit['quantite']); ?></td>
                <td><?php echo htmlspecialchars($produit['prix_unitaire']); ?> €</td>
                <td><?php echo htmlspecialchars($montant); ?> €</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Montant total</td>
            <td><?php echo htmlspecialchars($totalFacture); ?> €</td>
        </tr>
    </tfoot>
</table>

<livewire:counter/>

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>