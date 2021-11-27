@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vales de entrada</h1>
            <div class="d-sm-flex">
                <a href="{{url('/reportEntries')}}" class="btn btn-sm btn-warning shadow-sm mx-2">
                    <i class="fas fa-file-alt text-white-50"></i>
                    Reporte de entradas
                </a>
                <a href="{{url('entryvoucher/create')}}" class="btn btn-sm btn-success shadow-sm mx-2">
                    <i class="fas fa-plus-circle text-white-50"></i>
                    Crear vale
                </a>
                <a data-toggle="collapse" href="#collapseMaterial" class="btn btn-sm btn-primary shadow-sm mx-2" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fas fa-sliders-h text-white-50"></i></i>
                    Filtros
                </a>
                <form action="{{url('/entriesDeleted')}}" type="GET">
                    <button type="submit" href="#collapseMaterial" class="btn btn-sm btn-secondary shadow-sm mx-2">
                        <i class="fas fa-eye text-white-50"></i>Deshabilitados</button>
                </form>
            </div>
        </div>
        <div class="container-fluid">
            <div class="collapse" id="collapseMaterial">
                <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
                    <div style="float:none;" class="p-0 flex-grow-2 bd-highlight">
                        <form id="formGuide" type="GET" action="{{ url('/searchEntryVoucherDate') }}"
                              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input name="from" type="date" class="form-control bg-light border-1 small"
                                       aria-label="Search" aria-describedby="basic-addon2" required>
                                <input name="to" type="date" class="form-control bg-light border-1 small"
                                       aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit" required>
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div style="float:none;" class="p-0 flex-grow-2 bd-highlight">
                        <form id="formGuide" type="GET" action="{{url('/searchEntryVoucherProv')}}"
                              class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <input name="searchfor" type="text" class="form-control bg-light border-1 small" placeholder="Busqueda por proveedor"
                                       aria-label="Search" aria-describedby="basic-addon2" required>
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


        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de vales de entrada</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table style="text-align:center;" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Código</th>
                            <th>Hora de recepción</th>
                            <th>Fecha de recepción</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($datos as $data)
                            <tr>
                                <td>{{$data->ID_vale_entrada}}</td>
                                <td>{{$data->Hora}}</td>
                                <td>{{$data->Fecha_recepcion}}</td>
                                <td>
                                    <form action="{{url('/entryvoucher/'.$data->ID_vale_entrada)}}" method="post"
                                    class="formActions">
                                        <a class="btn btn-info" href="{{ url('/entryvoucher/'.$data->ID_vale_entrada) }}">
                                            Detalles
                                        </a>

                                        
                                        <a class="btn btn-dark " href="{{ url('/entryVoucherPDF/'.$data->ID_vale_entrada)  }}">
                                            Reporte
                                        </a>
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger " value="Borrar">
                                            Borrar
                                        </button>
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

@section('js')
            @if(session('Eliminar') == 'Ok')
                <script>
                    Toast.fire({
                        icon: 'success',
                        title: 'Eliminado Correctamente'
                    }).then((_)=>{
                        location.reload();
                    });
                </script>
            @elseif(session('Eliminar') == 'bad')
                <script>
                    Toast.fire({
                        icon: 'warning',
                        title: 'Existe algun error'
                    }).then((_)=>{
                        location.reload();
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
                            text: "El registro se deshabilitara",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Si, deshabilitalo!',
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
