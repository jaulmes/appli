@extends('dashboard.main')

@section('content')

<div class="card">
    <div class="card-header">
        <h1 class="card-title" >liste des utilisateurs</h1>
        <a href="{{route('users.create')}}" style="margin-left: 50em"><button type="button" class="btn btn-primary">ajouter</button></a>
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




    <!-- END: Alert -->
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td class="row">
                        <a href="{{route ('users.edit.admin', $user->id)}}">
                            <button type="button" class="btn btn-primary">modifier</button>
                        </a>
                        <form action="{{route('users.delete', $user->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('etes vous sur de vouloir suprimer cet utilisateur?')">suprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <th>Nom </th>
                    <th>Email </th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <!-- /.card-body -->
</div>



@endsection

@section('javascript')

@endsection