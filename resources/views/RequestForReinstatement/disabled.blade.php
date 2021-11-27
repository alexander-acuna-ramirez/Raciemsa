@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes De Reposición Desabilitadas</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="m-0 text-left row">
                <div class="col p-0 ">
                    <h6 class="m-0 pt-2 font-weight-bold text-primary">Lista de Solicitudes de Reposición Desabilitadas</h6>
                </div>
                <div class="d-sm-flex">
                    <a data-toggle="collapse" href="#collapseMaterial" class="btn btn-sm btn-primary shadow-sm mx-2" aria-expanded="false" aria-controls="collapseExample">
                        <i class="fas fa-sliders-h text-white-50"></i></i>
                    Filtros
                    </a>
                    <a href="{{url('/RequestForReinstatement')}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                    <i class="fa fa-eye text-white-70"></i> Mostrar Habilitados </a>
                </div>
            </div>
        </div>
        <div class="card-body">
        <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12" >
                            <div class="collapse" id="collapseMaterial">
                                <form action="{{ route('RequestForReinstatement.searchdisabled')}}" method="POST" id="" enctype="multipart/form-data"> 
                                @csrf
                                    <div class="form-group row">
                                        <label for="date" class="col-form-label">Fecha Solicitud:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date" id="datepicker">
                                                <input type="text"  class="form-control readonlyD" name="fromDate" id="fromDate" placeholder="De" data-date-language="es"  required autocomplete="off">
                                                <span class="input-group-append">
                                                    <span class="input-group-text bg-white">
                                                        <i class="fa fa-calendar" style="color:blue;"></i>
                                                    </span>
                                                </span>
                                            </div>                            
                                        </div>
                                        <label for="date" class="col-form-label">Fecha Solicitud:</label>
                                        <div class="col-sm-3">
                                            <div class="input-group date" id="datepicker">
                                                <input type="text"  class="form-control readonlyD" name="toDate" id="toDate" placeholder="Hasta" data-date-language="es" required autocomplete="off">
                                                <span class="input-group-append">
                                                    <span class="input-group-text bg-white">
                                                        <i class="fa fa-calendar" style="color:blue;"></i>
                                                    </span>
                                                </span>
                                            </div>                             
                                        </div>
                                        <div class="col">
                                            <br> 
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="container pl-0">
                                                <div class="row">
                                                    <button type="submit" class="btn btn-primary mr-4" name="search" title="Search" style="margin:0;">
                                                        <span class="icon text-white-60">
                                                        <i class="fa fa-search" aria-hidden="true"></i></span>
                                                    </button>
                                                    <a type="button" class="btn btn-secondary btn-md"  href="{{url('/RequestForReinstatement/disabled')}}">
                                                    <span class="text">Mostrar Todo</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="" width="100%" cellspacing="0">
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
                                <a class= "btn btn-info  btn-md" href="{{url('RequestForReinstatement/disabled/'.$data->Codigo_reposicion.'/showRequirementDisabled')}}">
                                    <span class="icon text-white-60">
                                    <i class="fa fa-eye" aria-hidden="true"></i></span>
                                </a>

                                <button class="btn btn-warning btn-flat btn-md remove-user" data-id="{{ $data->Codigo_reposicion }}" data-action="{{ route('RequestForReinstatement.delete',$data->Codigo_reposicion) }}" onclick="deleteConfirmation('{{$data->Codigo_reposicion}}','{{$data->Fecha_solicitud}}')">
                                    <span class="icon text-white-60">
                                    <i class="fa fa-reply-all" aria-hidden="true"></i></span>
                                </button>
                            </td>
                        </tr>
                        @endforeach    
                    </tbody>
                </table>
                {!! $datos->links() !!}

            </div>
        </div>
    </div>
</div>
@endsection
@section('js')

<script src="{{asset('admin/vendor/jquery/jquery.min.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
<script src="{{asset('admin/vendor/datepicker/js/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('admin/vendor/datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
<script type="text/javascript">
    function deleteConfirmation(id, date) {
        Swal.fire({
            title: "¿Estas Seguro?",
            html: 'La solicitud: <strong>'+id+' ('+date+')</strong> sera Habilitada',
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#2C4CF8',
            confirmButtonText: "Habilitar Solicitud",
            cancelButtonColor: '#d33',
            cancelButtonText: "Cancelar"
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = "{{ route('RequestForReinstatement.enable',[':id']) }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    success: function (results) {
                        if (results.status == 1) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                width:"25rem",
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'success',
                                html: 'La solicitud: <strong>'+id+' ('+date+')</strong> fue Habilitada correctamente',
                            });
                            setTimeout(function () {
                                location.reload(true);
                            },3500);
                        }else{
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                width:"25rem",
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            })
                            Toast.fire({
                                icon: 'error',
                                html: 'Ocurrio un error al intentar Habilitar la solicitud: <strong>'+id+' ('+date+')</strong>',
                            });
                        }
                    }
                });
            }else{
                e.dismiss;
            }
        },function (dismiss) {
            return false;
        })
    }
</script>
<script>
    $(function() {
        $('#fromDate').datepicker({
            format: "yyyy-mm-dd",
            startView: 1,
            language: "es",
            autoclose: true,
            todayHighlight: true
        });   
    });
    $(function() {
        $('#toDate').datepicker({
            format: "yyyy-mm-dd",
            startView: 1,
            language: "es",
            autoclose: true,
            todayHighlight: true
        });   
    });
</script>
<script>
    $(".readonlyD").on('keydown', function(e){
        if(e.keyCode != 9)
            e.preventDefault();
    });
</script>
@endsection