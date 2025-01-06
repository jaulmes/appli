<div>
    <div class="container mt-5">


        <!-- Sprint Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <span class="badge bg-secondary rounded-circle p-2">0</span>
                <span class="badge bg-primary rounded-circle p-2">0</span>
                <span class="badge bg-success rounded-circle p-2">0</span>
            </div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Launch demo modal
            </button>
        </div>

        <!-- Tickets Section -->
        <ul class="list-group mb-3">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                
            @foreach($taches as $taches)
                <div class="form-check">
                    <span class="fw-bold text-primary">SCRUM-2</span>
                </div>
                <div class="d-flex gap-2 align-items-center">
                    <select name="" id="" >
                        <option class="alert alert-dark" value="">A FAIRE</option>
                        <option class="alert alert-secondary" value="">EN COURS</option>
                        <option class="alert alert-success" value="">TERMINER</option>
                    </select>
                    <i class="bi bi-person-circle"></i>
                </div>
                @endforeach
            </li>
        </ul>

    </div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <livewire:modal-creer-tache>
    </div>
</div>
