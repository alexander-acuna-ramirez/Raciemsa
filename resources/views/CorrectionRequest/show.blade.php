@extends('layouts.master')

@section('content')
<div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DETALLE SOLICTUD DE CORRECCIÓN</h6>
            </div>
            <div class="card-body">
                    <div class="row">                 
                            <div class="col-3">
                                <label for="Codigo_solicitud_correccion">Codigo</label>
                                <input type="text" class="form-control"  disabled name="Codigo_solicitud_correccion" id="Codigo_solicitud_correccion" value="{{ $solicitud->Codigo_solicitud_correccion }}">
                            </div>
        
                            <div class="col-3">
                                <label for="Codigo_reposicion">Codigo reposicion</label>
                                <input type="text" class="form-control" disabled name="Codigo_reposicion" id="Codigo_reposicion" value="{{ $solicitud->Codigo_reposicion }}">
                            </div> 
                            <div class="col-3">
                                <label for="Codigo_guia_remision">Guia de remision</label>
                                <input type="text" class="form-control" disabled name="Codigo_guia_remision" id="Codigo_guia_remision" value="{{ $solicitud->Codigo_guia_remision }}">
                            </div>
                            <div class="col-3">
                                <label for="Motivo">Motivo</label>
                                <input type="text" class="form-control" disabled name="Motivo" id="Motivo" value="{{ $solicitud->Motivo}}">
                            </div>
                            <div class="col-3">
                                <label for="Fecha">Fecha</label>
                                <input type="text" class="form-control" disabled name="Fecha" id="Fecha" value="{{ $solicitud->Fecha }}">
                            </div>

                    </div>
                    <div class="row">
                        <div class="table-responsive px-4">
                            <table class=" mt-2 table table-bordered">
                                <thead>
                                    <th>
                                        Código Solicitud
                                    </th>
                                    <th>
                                        Nro. Parte
                                    </th>
                                    <th>
                                        Diferencia
                                    </th>
                                    <th>
                                        Acciones
                                    </th>
                                    
                                </thead>
                                <tbody>
                                    @foreach($correcciones as $data)
                                    <tr>
                                        <td>{{$data->Codigo_solicitud_correccion}}</td>
                                        <td>{{$data->Numero_de_parte}}</td>
                                        <td>{{$data->Diferencia}}</td>
                                        <td>
                                    <form action="{{url('/CorrectionRequest/'.$data->Codigo_solicitud_correccion)}}" method="get">
                                        <a class="btn btn-danger shadow-sm"  href="#}"> 
                                        <i class="fas fa-trash-alt"></i>                                                                         
                                        </a>       
                                                                                    
                                        </a>
                                    </form>
                                </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
              
            </div>
        </div>
    </div>

<a class="btn btn-primary shadow-sm"  href="{{url('/CorrectionRequest/')}}"> 
<i class="fas fa-arrow-circle-left"></i>
</a>
<div>
    <h1> </h1>
</div>  
@endsection