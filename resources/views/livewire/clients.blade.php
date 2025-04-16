<div>
    <div class="card fs-0.2" style="margin-top: 2em">
        <div class="card-header">
            <h3 class="card-title "><strong>Liste des clients</strong></h3>
            <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="search"  class="form-control float-right" 
                                placeholder="Search" wire:model="query" wire:input="update_search">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body table-responsive p-0" style="height: 400px; font-size: x-small;">
            <table class="table table-head-fixed text-nowrap">
                <thead>
                    <tr>
                        <th>Nom </th>
                        <th>Email</th>
                        <th>Adresse</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="result">
                    @foreach($clients as $client)
                    <tr :tache="$client" :key="$client->id">
                        <td><strong>{{$client->nom}}</strong><br><span style="font-size: xx-small;">{{$client->numero}}</span></td>
                        <td>{{$client->email?? '- '}}</td>
                        <td>{{$client->adresse?? '-'}}</td>
                        <td >
                            <!-- Modal -->
                            <livewire:modal-voir-activite-client :client="$client" :key="$client->id"/>
                            <span type="button" title="supprimer" style="font-size: x-large;">🚮</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                {{ $clients->links('pagination::bootstrap-4')}}
            </ul>
        </div>
    </div>
</div>
