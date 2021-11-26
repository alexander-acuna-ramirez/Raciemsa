@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Guía de remisión</h1>
            <div class="d-sm-flex">
                <a href="{{url('/guide/create')}}" class="btn btn-sm btn-success shadow-sm">
                    <i class="fas fa-plus-circle text-white-50"></i>
                    Crear guía
                </a>
                <a data-toggle="collapse" href="#collapseMaterial" class="btn btn-sm btn-primary shadow-sm mx-2" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-sliders-h text-white-50"></i></i>
                    Filtros
                </a>
                <a href="{{url('/disableGuides')}}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-eye text-white-50"></i> 
                    Deshabilitados
                </a>  
                <a href="{{url('/guide/create')}}" class="btn btn-sm btn-danger shadow-sm mx-2">
                    <i class="fas fa-file-alt text-white-50"></i>
                    Reporte
                </a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="collapse" id="collapseMaterial">
                <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
                    <div style="float:none;" class="p-0 flex-grow-2 bd-highlight">
                        <form id="formGuide" type="GET" action="{{ url('/searchbyDate') }}"
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
                    <div style="float:none;" class="p-0 flex-grow-2 bd-highlight">
                        <form id="formGuide" type="GET" action="{{ url('/searchGuide') }}"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input name="searchfor" type="text" class="form-control bg-light border-1 small" placeholder="Buscar por código"
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
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Lista de guías</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" 
                    cellspacing="0" style="text-align:center;">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Fecha de emisión</th>
                            <th>Inicio de traslado</th>
                            <th>Fin de traslado</th>
                            <th>Código de proveedor</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->Codigo_guia_remision}}</td>
                                <td>{{$data->Fecha_de_emision}}</td>
                                <td>{{$data->Inicio_traslado}}</td>
                                <td>{{$data->Fin_traslado}}</td>
                                <td>{{$data->Codigo_proveedor}}
                                <button value="{{$data->Codigo_proveedor}}" id="shProv" 
                                onclick='searchProv(this)' class="btn btn-link">
                                    <i class="fas fa-truck"></i>
                                </button>
                                <td>
                                    <form action="{{url('/guide/'.$data->Codigo_guia_remision)}}" method="post"  class="formActions">
                                        <a class="btn btn-success" href="{{url('/guide/'.$data->Codigo_guia_remision.'/edit')}}">
                                        <i class="fas fa-edit"></i>
                                        </a>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button class="btn btn-danger d-inline" value="{{$data->Codigo_guia_remision}}" 
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
</div>
<script>
    const boton = document.querySelectorAll("#shProv");
    function searchProv(element){
        axios.get("searchProveedor/"+element.value).then((response)=>{
            if(response.status===200 && response.data.length>0){
                Swal.fire({
                    icon: 'success',
                    title: 'Datos del proveedor',
                    text: response.data[0].Razon_social+' '+response.data[0].RUC+' '+response.data[0].Correo
                })
            }
        }) 
    }
</script>
@endsection
@section('js')
            @if(session('Eliminar') == 'Ok')
                <script>
                    Toast.fire({
                        icon: 'success',
                        title: 'Deshabilitado Correctamente'
                    })
                </script>
            @elseif(session('Eliminar') == 'bad')
                <script>
                    Toast.fire({
                        icon: 'warning',
                        title: 'No se pudo deshabilitar'
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
