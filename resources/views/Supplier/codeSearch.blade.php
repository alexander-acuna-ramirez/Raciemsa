@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
        <a href="{{url('/supplier/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle text-white-50"></i>Agregar Nuevo Proveedor</a>
    </div>
    <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a data-toggle="collapse" href="#collapseMaterial" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" aria-expanded="false" aria-controls="collapseExample">
            <i class="fas fa-search text-white-50"></i> Búsqueda de proveedor </a>
    </div>
    <div class="collapse" id="collapseMaterial">
        
        <div style="float:none;margin:auto;" class="p-0 flex-grow-2 bd-highlight">
            <span class="h8 mb-0 text-gray-800">Filtrar por código:</span>    
            <form id="formGuide" type="GET" action="{{ url('/searchSupplier') }}"
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Proveedores</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codigo del proveedor</th>
                            <th>Razon Social</th>
                            <th>Numero de RUC</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                            <tr>
                                <td>{{$data->Codigo_proveedor}}</td>
                                <td>{{$data->Razon_social}}</td>
                                <td>{{$data->RUC}}</td>
                                
                                <td>
                                    <form action="{{url('/supplier/'.$data->Codigo_proveedor)}}" method="post" class="formActions">
                                        <a class="btn btn-success" href="{{url('/supplier/'.$data->Codigo_proveedor) }}">
                                            <i class="fas fa-eye"></i>
                                            <span class="text">Mostrar Informacion</span>
                                        </a>
                                        @csrf 
                                        {{ method_field('DELETE')}}
                                        <button type="submit" class="btn btn-danger ">
                                            <i class="fas fa-trash"></i>
                                            <span class="text">Eliminar</span>
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
    @if(session('Eliminar')=='ok')
        <script>
            Toast.fire({
                icon: 'success',
                tittle: 'Proveedor Eliminado Correctamente'
            })
        </script>
    @elseif(session('Eliminar')=='bad')
        <script>
            Toast.fire({
                icon: 'warning',
                title: 'No se ha podido eliminar el Proveedor'
            })
        </script>
    @endif
    <script>
        const form = document.querySelectorAll('.formActions')
        forms.foreach( (form)=>{
            form.addEventListener("submit", function (e){
                e.preventDefault();
                Swal.fire({
                    title: 'Esta seguro de eliminar el registro?',
                    text: "la informacion del proveedor se deshabilitara",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, deshabilitalo!',
                    cancelButtonText: 'Cancelar'
                }).then(function (result){
                    if (result.isConfirmed){
                        form.submit();
                    }
                })
            })
        });
    </script>
@endsection