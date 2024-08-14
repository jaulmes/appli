@extends('dashboard.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
        <p style="margin-left: 50em;">
            <a href="{{ route('permission.create')}}"> 
                <button class="btn btn-primary">
                    ajouter une permission
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
                    <th>titre</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr>
                    <td>{{$permission->name}}</td>
                    <td class="row">
                        <a href="{{route ('permission.edit', $permission->id)}}">
                            <button type="button" class="btn btn-primary">modifier</button>
                        </a>
                        <form action="{{route('permission.delete', $permission->id)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('etes vous sur de vouloir suprimer cette permission?')">suprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                
            </tbody>
            <tfoot>
                <tr>
                    <th>titre</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
        </table>
    </div>

    
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
<!-- /.col -->
</div>
<!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>

@endsection