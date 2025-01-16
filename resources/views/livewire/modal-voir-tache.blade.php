
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="detailTache">Details de la tache</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body fs-0.1">
        <div class="row">
            <div class="mb-3 col">
                <label for="exampleFormControlInput1" class="form-label">Titre: {{$tache->titre}}</label>
            </div>
            <div class="mb-3 col ">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" wire:model="description" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col">
                <label for="validationCustom04" class="form-label">Statut</label>
                <select class="form-select"  required>
                    <option selected >Choisir le statut</option>
                    <option value="A FAIRE" >A FAIRE</option>
                    <option value="EN COURS">EN COURS</option>
                    <option value="TERMINE" >TERMINE</option>
                </select>
            </div>

        </div>

    </div>
</div>
