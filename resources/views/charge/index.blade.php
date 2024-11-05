@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Listes des ventes</h3>
    </div>
    <div class="container-xl px-4 mt-n4">
        @if (session()->has('success'))
        <div class="alert alert-success alert-icon" role="alert">
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon-aside">
                <i class="far fa-flag"></i>
            </div>
            <div class="alert-icon-content">
                {{ session('success') }}
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card" style="margin-top: 2em">
                <div class="card-body table-responsive p-0" style="height: 400px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>titre</th>
                                <th>montant</th>
                                <th>date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($charges as $charge)
                            <tr>
                                <td>{{ $charge->titre }}</td>
                                <td>{{ $charge->montant }}</td>
                                <td>{{ $charge->date }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('charges.add', $charge->id) }}" class="btn btn-outline-primary btn-sm mx-1"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('charges.showChargeDetail', $charge->id) }}" class="btn btn-outline-primary btn-sm mx-1"><i class="bi bi-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
<!-- /.card-body -->
</div>

                
                
                
<!-- END: Main Page Content -->
@endsection