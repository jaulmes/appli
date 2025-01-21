
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="detailTache">Details de la tache</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body fs-0.1">
        <div class="row">
            <div class="mb-3 col">
                <label for="exampleFormControlInput1" class="form-label">Titre</label>
                <div>
                    <span>{{$tache->titre}}</span>
                </div>
            </div>
            <div class="mb-3 col ">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <div>
                    <span>{{$tache->description}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Statut</label>
                <div>
                    <span>{{$tache->statut}}</span>
                </div>
            </div>
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Responsable</label>
                <div>
                    <span>{{$tache->assigne->name?? "non assigne"}}</span>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Debut</label>
                <div>
                    <span>{{$tache->date_debut}}</span>
                </div>
            </div>
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Fin</label>
                <div>
                    <span>{{$tache->date_fin}}</span>
                </div>
            </div>

        </div>

    </div>
</div>
