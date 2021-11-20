@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes De Reposicion</h1>
        <a href="{{url('/RequestForReinstatement/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle text-white-50"></i> Crear Solicitud </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Solicitudes de Reposicion</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Proveedor</th>
                            <th>Fecha de la Solicitud</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->Codigo_reposicion}}</td>
                                <td>{{$data->Razon_social}}</td>
                                <td>{{$data->Fecha_solicitud}}</td>
                                <td>
                                    <form action="{{url('/RequestForReinstatement/'.$data->Codigo_reposicion)}}" method="post">
                                        <a class="btn btn-info" href="{{url('/RequestForReinstatement/'.$data->Codigo_reposicion.'/show')}}">
                                            Ver
                                        </a>
                                        <a class="btn btn-success" href="{{url('/RequestForReinstatement/'.$data->Codigo_reposicion.'/edit')}}">
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
            </div>
        </div>
</div>
@endsection