<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport de Simulation</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 10px; }
        h1 { text-align: center; color: #2c3e50; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; background-image: url('logo.jpg'); background-repeat: no-repeat; background-position: center; opacity: 0.05; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th.section-header { background: #f0f0f0; text-align: center; font-size: 16px; }
        td.title { font-weight: bold; }
        .footer { margin-top: 15px; font-size: 12px; color: #555; text-align: center; }
        .footer a { color: #2c3e50; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Rapport de Simulation Solaire</h1>
    <table>
        <!-- Section Appareils -->
        <tr><th class="section-header" colspan="4">Liste des Appareils</th></tr>
        <tr>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Puissance (W)</th>
            <th>Durée (h/j)</th>
        </tr>
        @foreach($appareils as $appareil)
        <tr>
            <td>{{ $appareil['name'] }}</td>
            <td>{{ $appareil['quantity'] }}</td>
            <td>{{ $appareil['power'] }}</td>
            <td>{{ $appareil['duration'] }}</td>
        </tr>
        @endforeach

        <!-- Section Paramètres de Simulation -->
        <tr><th class="section-header" colspan="4">Paramètres de Simulation</th></tr>
        <tr><td class="title" colspan="3">Coefficient de sécurité</td><td>{{ $coeficient_securite }} %</td></tr>
        <tr><td class="title" colspan="3">Ensoleillement du site</td><td>{{ $ensoleillement_site }} Kw/m²</td></tr>
        <tr><td class="title" colspan="3">Efficacité de l'installation</td><td>{{ $efficacite_installation }} %</td></tr>
        <tr><td class="title" colspan="3">Tension entre panneaux</td><td>{{ $tension_entre_panneau }} V</td></tr>
        <tr><td class="title" colspan="3">Autonomie souhaitée</td><td>{{ $autonomie_generale }} jrs</td></tr>
        <tr><td class="title" colspan="3">Tension batterie</td><td>{{ $tension_batterie }} V</td></tr>
        <tr><td class="title" colspan="3">Tension de sortie batterie</td><td>{{ $tension_sortie_batterie }} V</td></tr>
        <tr><td class="title" colspan="3">Profondeur de décharge (DOD)</td><td>{{ $DOD_batterie }} %</td></tr>
        <tr><td class="title" colspan="3">Batterie souhaitée</td><td>{{ $batteri_souhaite }} {{ $unite_batterie }}</td></tr>

        <!-- Section Résultats -->
        <tr><th class="section-header" colspan="4">Résultats de la Simulation</th></tr>
        <tr><td class="title" colspan="3">Énergie totale</td><td>{{ $energie_totale }} Wh/jour</td></tr>
        <tr><td class="title" colspan="3">Besoin énergétique journalier</td><td>{{ $besoin_energetique_journalier }} Wh/jour</td></tr>
        <tr><td class="title" colspan="3">Puissance champ panneaux</td><td>{{ $puissance_champ_panneaux }} W</td></tr>
        <tr><td class="title" colspan="3">Nombre de panneaux ({{ $nombre_watt_panneaux }} W)</td><td>{{ ceil($nombre_panneaux) }}</td></tr>
        <tr><td class="title" colspan="3">Capacité batterie</td><td>{{ $capacite_batterie }} {{ $unite_capacite_batterie }}</td></tr>
        @if($unite_capacite_batterie == 'Ah')
            <tr><td class="title" colspan="3">Nombre de batteries ({{$batteri_souhaite}} Ah)</td><td>{{ ceil($nombre_batteries) }}</td></tr>
        @elseif($unite_capacite_batterie == 'Wh')
            <tr><td class="title" colspan="3">Nombre de batteries ({{$batteri_souhaite}} Wh)</td><td>{{ ceil($nombre_batteries) }}</td></tr>
        @endif
        <tr><td class="title" colspan="3">Courant mini contrôleur</td><td>{{ $courant_minimun_controlleur }} A</td></tr>
        <tr><td class="title" colspan="3">Puissance convertisseur</td><td>{{ $puissance_convertisseur }} W</td></tr>
    </table>

    <div class="footer">
        <p>Simulation réalisée sur le site : <a href="{{ route('simulateur') }}" target="_blank">solergy-solutions.com</a></p>
        <p>Disclaimer: Cette simulation est fournie à titre indicatif. Solergy Solutions SARL décline toute responsabilité en cas d’erreur ou de problème résultant de l’usage de ces données.</p>
    </div>
</body>
</html>
