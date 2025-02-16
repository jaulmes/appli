@extends('dashboard.main')

@section('content')

<section class="h-100 h-custom">
    <div class="container h-100 py-5">
        <div class="col">
            
            <div class="table-responsive" style="display: flex; flex-direction: row">

                <!--catalogue de produit avec livewire-->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <livewire:catalogue-produit/>
                    </div>
                </div>

                <div >
                    <div class="card-body p-4" >
                        <!--mon panier-->
                        <livewire:mon-panier/>
                        <!-- Modal -->
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <!--modal avec livewire-->
                                    <livewire:modal-vente-et-installation/>
                                </div>
                            </div>
                        </div>
                        <!-- Fin du modal -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radioButtons = document.querySelectorAll('input[name="option"]');
        const formYes = document.getElementById('formYes');
        const formNo = document.getElementById('formNo');
        
        radioButtons.forEach(radio => {
            radio.addEventListener('change', function () {
                if (this.value === 'yes') {
                    formYes.style.display = 'block';
                    formNo.style.display = 'none';
                } else if (this.value === 'no') {
                    formYes.style.display = 'none';
                    formNo.style.display = 'block';
                }
            });
        });
    });
</script>
@endsection
