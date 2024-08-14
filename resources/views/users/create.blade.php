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
                    <form method="post" action="{{route('users.store')}}" >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mx-4" >
                                    <label for="name">nom </label>
                                    <input name="name" type="text" class="form-control" id="name" placeholder="entrer le nom de l'utilisateur">
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
                                    <input name="email" type="email" class="form-control" id="email" placeholder="entrer l'email'">
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group mx-4">
                                    <label for="numero">numero de telephone </label>
                                    <input name="numero" type="number" class="form-control" id="numero" placeholder="entrer le  numero">
                                    @error('numero')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group mx-4">
                                    <label for="password">Mot de passe </label>
                                    <input type="password" name="password" id="password">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group mx-4">
                                    <label for="role">Role </label>
                                    <select name="role_id" class="form-control" id="role" required>
                                            <option value="" selected disabled> choisir le role</option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
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