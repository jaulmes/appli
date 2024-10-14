@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid mr-5 " style="margin-left: 300px; position: relative;">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">


                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                    <div class="card-header">
                        <h3 class="card-title">Quick Example</h3>
                    </div>
                    <form method="post" action="{{route('produit.storeFournisseur')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mx-3" >
                                    <label for="titre">nom </label>
                                    <input name="nom" type="text" class="form-control" id="nom" placeholder="entrer le nom du fournisseur" required> 
                                    @error('nom')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="prenom">prenom</label>
                                    <input name="prenom" type="text" class="form-control" id="prenom" placeholder="entrer le prenom du fournisseur" > 
                                    @error('prenom')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="row">
                                    <div class="form-group mx-3">
                                        <label for="telephone">telephone </label>
                                        <input name="telephone" type="number" class="form-control" id="telephone" placeholder="entrer le numero de telephone du fournisseur" required>
                                        @error('telephone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="localisation">localisation </label>
                                        <input name="localisation" type="text" class="form-control" id="localisation" placeholder="entrer la localisation du fourniseur" >
                                    </div>
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