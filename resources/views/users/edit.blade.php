@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid mr-5 " style="margin-left: 300px; position: relative;">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="card card-primary">
                    
                    <div class="container-xl px-4 mt-n4">
                        @if (session()->has('error'))
                        <div class="alert alert-danger alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="far fa-flag"></i>
                            </div>
                            <div class="alert-icon-content">
                                {{ session('error') }}
                            </div>
                        </div>
                        @endif
                    </div>
                    
                    <div class="container-xl px-4 mt-n4">
                        @if (session()->has('message'))
                        <div class="alert alert-success alert-icon" role="alert">
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            <div class="alert-icon-aside">
                                <i class="far fa-flag"></i>
                            </div>
                            <div class="alert-icon-content">
                                {{ session('message') }}
                            </div>
                        </div>
                        @endif
                    </div>


                    <div class="card-header">
                        <h3 class="card-title">Quick Example</h3>
                    </div>
                    <form method="post" action="{{route('users.update', $users->id)}}" >
                        @method('patch')
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mx-4" >
                                    <label for="name">nom </label>
                                    <input name="name" value="{{old('name')?? $users->name}}" type="text" class="form-control" id="name" placeholder="entrer le nom de l'utilisateur" require>
                                    @error('titre')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mx-4">
                                    <label for="email">email </label>
                                    <input name="email" value="{{old('email')?? $users->email}}" type="email" class="form-control" id="email" placeholder="entrer l'email'">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mx-4">
                                    <label for="numero">numero de telephone </label>
                                    <input name="numero" value="{{old('numero')?? $users->numero}}" type="number" class="form-control" id="numero" placeholder="entrer le  numero">
                                    @error('numero')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div>
                                    <div class="form-group mx-4">
                                        <label for="current_password">mot de passe actuelle </label>
                                        <input name="current_password"  type="text" class="form-control" id="current_password" placeholder="Entrez l'actuel mot de passe">
                                        @error('current_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>                                
                                    <div class="form-group mx-4">
                                        <label for="new_password">Nouveau mot de passe</label>
                                        <input name="new_password"  type="text" class="form-control" id="new_password" placeholder="Entrez le nouveau mot de passe">
                                        @error('new_password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
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