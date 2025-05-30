<div style="font-size: small;">
    <div class="card-header border-0">
        <h3 class="card-title">Packs</h3>
        @if (session()->has('message_pack'))
            <div class="alert alert-success">
                {{ session('message_pack') }}
            </div>
        @endif
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>packs</th>
                    <th>Descriptions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($packs as $pack)
                    <tr>
                        <td>
                            @php
                                $image1 = public_path('images/packs/'. $pack->image);
                                $image2 = public_path('storage/images/packs/'. $pack->image);
                                $url = file_exists($image1)? asset('images/packs/'. $pack->image)
                                                            : asset('storage/images/packs/' . $pack->image);
                            @endphp
                            <img src="{{$url }}"
                                class="img-circle img-size-32 mr-2" 
                                ></br>
                           
                            {{$pack->titre}}
                        </td>
                        <td>{!! str_replace(';', ';<br>', e($pack->description)) !!}</td>

                        <td>
                            <!-- Modal modifier pack-->
                             
                            <div  class="modal fade" id="editPack-{{$pack->id}}" wire:ignore.self data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editPackLabel" aria-hidden="true">
                                <livewire:edit-pack-admin :pack="$pack" />
                            </div>
                            <i class="bi bi-pencil-square text-blue"  type="button" data-bs-toggle="modal" data-bs-target="#editPack-{{$pack->id}}" ></i>
                            <i class="fas fa-trash text-red" type="button"
                                onclick="if(confirm('Êtes-vous sûr de vouloir supprimer ce pack ?')) 
                                { @this.call('deletePack', {{ $pack->id }}) }">
                            </i>
                        </td>
                    </tr>
                @empty
                    <td colspan="4" style="text-align: center;"> Auccune pack</td>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
