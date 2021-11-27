@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes de Corrección</h1>        
    </div>    

    <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a data-toggle="collapse" href="#collapseMaterial" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-search text-white-50"></i> Búsqueda de Solicitudes </a>
    </div>
    <div class="collapse" id="collapseMaterial">
        <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
        <div style="float:none;margin:auto;" class="p-0 flex-grow-2 bd-highlight">
            <span class="h8 mb-0 text-gray-800">Filtrar por fecha:</span>    
            <form id="formGuide" type="GET" action="{{ url('/searchbyDateCorrection') }}"
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input name="from" type="date" class="form-control bg-light border-1 small"
                    aria-label="Search" aria-describedby="basic-addon2">
                    <input name="to" type="date" class="form-control bg-light border-1 small"
                    aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div style="float:none;margin:auto;" class="p-0 flex-grow-2 bd-highlight">
            <span class="h8 mb-0 text-gray-800">Filtrar por código:</span>    
            <form id="formGuide" type="GET" action="{{ url('/searchRequestCorrection') }}"
                class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input name= 'Buscarpor' type="text" class="form-control bg-light border-1 small" placeholder="Buscar..."
                    aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </div>
</div>
    <div>
        <h6></h6>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de solicitudes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Código de Corrección</th>
                            <th>Código de Reposición</th>
                            <th>Guía de Remisión</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->Codigo_solicitud_correccion}}</td>
                                <td>{{$data->Codigo_reposicion}}</td>
                                <td>{{$data->Codigo_guia_remision}}</td>
                                <td>{{$data->Motivo}}</td>
                                <td>{{$data->Fecha}}</td>
                                <td>
                                    <form action="{{url('/CorrectionRequest/'.$data->Codigo_solicitud_correccion)}}" method="get">
                                        <a class="btn btn-success shadow-sm"  href="{{url('/CorrectionRequest/'.$data->Codigo_solicitud_correccion.'')}}"> 
                                        <i class="fas fa-eye"></i>                                                                             
                                        </a>       
                                        
                                        <a class="btn btn-primary shadow-sm align-middle text-center"  href=""> 
                                        <i class="fas fa-file-pdf"></i>                                                                           
                                        </a>

                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger d-inline" href="{{url('/CorrectionRequest/change_status/'.$data->Codigo_solicitud_correccion)}}" id="status" value="{{$data->Codigo_solicitud_correccion}}" 
                                        type="submit">
                                        <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
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