@extends('dashboard.main')
@section('content')
<section class="h-100 h-custom">
    <div class="container h-100 py-5">
        <div class="col">
            <div class="table-responsive" style="display: flex; flex-direction: row">
                <div class="card-body">
                    <div class="tab-content p-0">
                        <livewire:catalogue-aprovisionnement-produit/>
                    </div>
                </div>

                <div >
                    <div class="card-body p-4">
                        <!--panier aver livewire-->
                        <livewire:panier-aprovisionnement/>
                        <!-- Modal -->
                        <div class="col-md-6 col-lg-4 col-xl-3 mb-4 mb-md-0">
                          <div>
                            <livewire:modal-valider-bon-commandes/>
                          </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection