<div>
    <tr>
        <td>{{ $vente->nomClient}}</td>
        <td>{{$vente->numeroClient}}</td>
        <td>{{$vente->user->name}}</td>
        <td>{{$vente->agentOperant}}</td>
        <td>{{$vente->commission}}</td>
        <td>{{$vente->qteTotal}}</td>
        <td>{{$vente->NetAPayer}}</td>
        <td>{{$vente->montantTotal}}</td>
        <td>{{$vente->montantVerse}}</td>
        <td>{{$vente->NetAPayer - $vente->montantVerse}}</td>
        <td>{{$vente->date}}</td>
        <td>{{$vente->statut}}</td>
        @if($vente->statut == "non termine")
            <td>
                <a href="{{ route('ventes.voir.ajouterPaiement', $vente->id)}}">
                    <button type="button" class="btn btn-primary" >
                        Ajouter un paiement
                    </button>
                </a>
            </td>
        @endif
    </tr>
</div>
