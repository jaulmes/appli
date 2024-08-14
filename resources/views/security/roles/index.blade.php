@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
        <p style="margin-left: 50em;">
            <a href="{{ route('role.create')}}"> 
                <button class="btn btn-primary">
                    ajouter un role
                </button>
            </a>
        </p>
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
                    <th>Titre</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{$role->name}}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                            {{$permission->name}},
                         @endforeach
                    </td>
                    <td class="row">
                        <a href="{{route ('role.edit', $role->id)}}">
                            <button type="button" class="btn btn-primary">modifier</button>
                        </a>
                        <form action="{{route('role.delete', $role->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('etes vous sur de vouloir suprimer cet role?')">suprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <th>Titre</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <!-- /.card-body -->
</div>


@endsection