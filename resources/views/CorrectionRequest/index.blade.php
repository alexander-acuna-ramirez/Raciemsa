@extends('layouts.master')

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-right justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes de Corrección</h1>
        <a href="{{url('/CorrectionRequest/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-plus-circle text-white-50"></i>Crear Solicitud</a>
        <a data-toggle="collapse" href="#collapseMaterial" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-search text-white-50"></i> Búsqueda de Solicitudes</a>
        <a class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm"  href="{{url('/CorrectionRequestdisabled')}}">
            <i class="fas fa-eye text-white-50"></i>Ver Solicitudes Deshabilitadas</a>
        <a class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"  href="{{url('/reportCorrections')}}">
            <i class="fas fa-file-pdf"></i> </i>Generar reporte</a>
    </div>    

    <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4"></div>
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
    <div class="card shadow mb-8">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de solicitudes</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codigo de Corrección</th>
                            <th>Codigo de Reposición</th>
                            <th>Guia de Remisión</th>
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
                                    <form action="{{url('/CorrectionRequest/'.$data->Codigo_solicitud_correccion)}}" method="post" class="formActions" id="status">
                                        <a type="submit" class="btn btn-success shadow-sm align-middle text-center"  href="{{url('/CorrectionRequest/'.$data->Codigo_solicitud_correccion.'')}}"> 
                                        <i class="fas fa-eye"></i>                                                                             
                                        </a>       
                                        
                                        <a class="btn btn-primary shadow-sm align-middle text-center"  href="{{ url('/correctionRequestPDF/'.$data->Codigo_solicitud_correccion.'')}}"> 
                                        <i class="fas fa-file-pdf"></i>                                                                           
                                        </a>

                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger d-inline align-middle text-center" href="{{url('/CorrectionRequest/change_status/'.$data->Codigo_solicitud_correccion)}}" id="status" value="{{$data->Codigo_solicitud_correccion}}" 
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
@endsection

@section('js')
            @if(session('Eliminar') == 'Ok')
                <script>
                    Toast.fire({
                        icon: 'success',
                        title: 'Eliminado Correctamente'
                    })
                </script>
            @elseif(session('Eliminar') == 'bad')
                <script>
                    Toast.fire({
                        icon: 'warning',
                        title: 'Existe algún error'
                    })
                </script>
            @endif
            <script>
                const forms = document.querySelectorAll('.formActions');
                forms.forEach( (form)=>{
                    form.addEventListener("submit",function (e){
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "El registro se deshabilitará",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, deshabilítalo!',
                            cancelButtonText: 'Cancelar'
                        }).then(function (result){
                            if(result.isConfirmed){
                                form.submit();
                            }
                        })
                    })
                });
            </script>
@endsection
