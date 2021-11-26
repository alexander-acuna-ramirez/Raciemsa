@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Guía de remisión</h1>
            <div class="d-sm-flex">
                <a data-toggle="collapse" href="#collapseMaterial" class="btn btn-sm btn-primary shadow-sm mx-2" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-sliders-h text-white-50"></i></i>
                    Filtros
                </a>
                <a href="{{url('/guide')}}" class="btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-eye text-white-50"></i> 
                    Habilitados
                </a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="collapse" id="collapseMaterial">
                <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
                    <div style="float:none;" class="p-0 flex-grow-2 bd-highlight">
                        <form id="formGuide" type="GET" action="{{ url('/searchbyDateDisable') }}"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input name="fromDate" type="date" class="form-control bg-light border-1 small"
                                aria-label="Search" aria-describedby="basic-addon2">
                                <input name="toDate" type="date" class="form-control bg-light border-1 small"
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
                        <form id="formGuide" type="GET" action="{{ url('/searchGuideDisable') }}"
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input name="search" type="text" class="form-control bg-light border-1 small" placeholder="Buscar por código"
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
                            <th>Estado</th>
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
                                    <button type="button" class="btn btn-danger" disabled>
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
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
                        title: 'Eliminado Correctamente'
                    })
                </script>
            @elseif(session('Eliminar') == 'bad')
                <script>
                    Toast.fire({
                        icon: 'warning',
                        title: 'Existe algun error'
                    })
                </script>
            @endif
            <script>
                const forms = document.querySelectorAll('.formActions');
                forms.forEach( (form)=>{
                    form.addEventListener("submit",function (e){
                        e.preventDefault();
                        Swal.fire({
                            title: '¿Estas seguro?',
                            text: "El registro se deshabilitará",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, deshabilítalo!',
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
