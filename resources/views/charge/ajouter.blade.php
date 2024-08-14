@extends('dashboard.main')

@section('specificpagescripts')
<script src="{{ asset('assets/js/img-preview.js') }}"></script>
@endsection

@section('content')
<!-- BEGIN: Header -->
<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fa-solid fa-users"></i></div>
                        ajouter les charges
                    </h1>
                </div>
            </div>

        </div>
    </div>
</header>
<!-- END: Header -->

<!-- BEGIN: Main Page Content -->
<div class="container-xl px-2 mt-n10">
    <form action="{{ route('charges.addDetail', $charges->id) }}" method="POST" >
        @csrf

        <div class="row">
    
            <div class="col-xl-8">
                <!-- BEGIN: Customer Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        details de la charge
                    </div>
                    <div class="card-body">
                        <!-- Form Group (titre) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="titre">titre <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('name') is-invalid @enderror" id="titre" name="titre" type="text" placeholder="" required />
                            @error('titre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1" for="montant">Compte<span class="text-danger">*</span></label>
                            <select class="form-control form-control-solid" name="compte_id" required>
                                <option disable selected=""> Choisir un compte</option>
                                @foreach($comptes as $compte)
                                <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                @endforeach
                            </select>
                            @error('compte_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Form Group (montant) -->
                        <div class="mb-3">
                            <label class="small mb-1" for="montant">montant <span class="text-danger">*</span></label>
                            <input class="form-control form-control-solid @error('montant') is-invalid @enderror" id="montant" name="montant" type="number" placeholder="entrer le montant..." required />
                            @error('montant')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number) -->
                            <div class="col-md-6">
                                <label class="small mb-1" for="date">date <span class="text-danger">*</span></label>
                                <input class="form-control form-control-solid @error('date') is-invalid @enderror" id="date" name="date" type="date" placeholder="" required />
                                @error('date')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="detail">detail <span class="text-danger">*</span></label>
                                <textarea class="form-control form-control-solid @error('detail') is-invalid @enderror" name="detail" id="detail" cols="30" rows="10" required></textarea>
                                @error('detail')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            
                        </div>
                       


                        <!-- Submit button -->
                        <button class="btn btn-primary" type="submit">valider</button>
                        <a class="btn btn-danger" href="{{ route('charges.index') }}">Cancel</a>
                    </div>
                </div>
                <!-- END: Customer Details -->
            </div>
        </div>
    </form>
</div>
<!-- END: Main Page Content -->
@endsection
