@extends('dashboard.main')

@section('content')
<section class="content">
    <div class="container-fluid mr-5 " >
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
                        <h3 class="card-title">Ajouter une permission</h3>
                    </div>
                    <form method="post" action="{{route('permission.store')}}" >
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group mx-5">
                                    <label for="titre">titre </label>
                                    <input name="name" type="text" class="form-control" id="titre" placeholder="entrer le titre">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
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