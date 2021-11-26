@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes De Reposicion</h1>
        <a href="javascript:history.back()" class="btn btn-md btn-primary">
            <span class="icon text-white-50">
                <i class="fa fa-arrow-left"></i>
            </span>
            <span class="text"> Volver</span>
        </a>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Detalle de Solicitud</h6>
        </div>
        <div class="card-body">
        <div>
            @foreach($reinstatement as $data)
                <form action="{{url('/RequestForReinstatement/'.$data->Codigo_reposicion)}}" class="" method="post">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="Codigo_reposicion">Codigo</label>
                            <input type="text" class="form-control" readonly name="Codigo_reposicion" id="Codigo_reposicion" value="{{ $data->Codigo_reposicion }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Razon_Social">Proveedor</label>
                            <input type="text" class="form-control" readonly name="Razon_Social" id="Razon_Social" value="{{ $data->Razon_social }}">                      
                        </div>
                        <div class="form-group col-md-4">
                            <label for="Fecha_solicitud">Fecha de la Solicitud</label>
                            <input type="text" class="form-control" readonly name="Fecha_solicitud" id="Fecha_solicitud" value="{{ $data->Fecha_solicitud }}">                                           
                        </div>
                    </div>                                      
                </form>
            @endforeach
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Materiales</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Descripcion</th>
                            <th>Cantidad</th>
                            <th>Prioridad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reinstatements0 as $data)
                        <tr>
                            <td>{{$data->Descrip}}</td>
                            <td>{{$data->Cant}}</td>
                            <td>{{$data->Priori}}</td>
                            <td>{{$data->Observaciones}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection