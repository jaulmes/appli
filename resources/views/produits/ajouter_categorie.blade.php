@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid " style="margin-left: 300px;">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-secondary">
                  
                        @if(session()->has('message'))
                        <div class="alert alert-success alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-content">
                                {{ session('message') }}
                            </div>
                        </div>
                        @endif
                   
                    <div class="card-header">
                        <h3 class="card-title">Custom Elements</h3>
                    </div>
                    <form method="post" action="{{route('produit.store_categori')}}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="titre">titre</label>
                                <input type="text" name="titre" class="form-control" id="titre" placeholder="entrer le titre de la categorie" required>

                            </div>
                            <div class="form-group">
                                <label for="des">description</label>
                                <textarea class="form-control" name="description" id="" cols="10" rows="10" placeholder="description" ></textarea>

                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection