@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Catalogos</h1>
        <a href="{{url('/catalog/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle text-white-50"></i> Crear catalogo </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de catalogos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Ubicacion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->ID_Catalogo}}</td>
                                <td>{{$data->Ubicacion}}</td>
                                <td>
                                    <!--<a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">
                                        Editar
                                    </a>-->
                                    <form action="{{url('/catalog/'.$data->ID_Catalogo)}}" method="post">
                                        <a class="btn btn-success" href="{{url('/catalog/'.$data->ID_Catalogo.'/edit')}}">
                                            Editar
                                        </a>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input class="btn btn-danger d-inline" type="submit"
                                        onclick="return confirm('¿Seguro que quieres borrar esto?')"
                                        value="Borrar">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $datos->links() !!}
            </div>
        </div>
</div>
@endsection