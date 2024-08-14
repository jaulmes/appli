@extends('dashboard.main')

@section('content')
<section class="content">
<div class="container-xl px-2 mt-n10">
    <form action="{{ route('produit.storeImportProduit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xl-12">
                <!-- Import products -->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Import Product</div>
                    <div class="card-body">
                        <!-- Import product input -->
                        <input class="form-control form-control-solid mb-3 @error('file') is-invalid @enderror" type="file"  id="file" name="file" >
                        <button class="btn btn-primary" type="submit">Import</button>
                        @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <!-- Import products -->
            </div>
        </div>
    </form>
</div>
</section>
@endsection