@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error )
        <li style="list-style: none">
            {{ $error }}
        </li>
        @endforeach
    </div>
    @endif

        <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
            <h1 class="h3 mb-0 text-gray-800">Catálogo </h1>
            <div class="d-sm-flex">
                <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" data-toggle="modal"
                data-target="#catalogaddmodal"><i class="fas fa-plus-circle text-white-50"></i> Crear catálogo </a>
                <a class="btn btn-sm btn-warning shadow-sm mx-2" aria-expanded="false"  href="{{url('/reporteValorizado')}}">
                    <i class="fas fa-file-alt text-white-50"></i>
                    Reporte Valorizado
                </a>
        </div> </a>
        </div>
 <!--Search-->

 <nav class="navbar navbar-light ">
        <form class="form-inline ">
            <input name="buscarCatalog" class="form-control mr-sm-2 typeahead" type="search" placeholder="Código catálogo"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

        <div class="col-md-8" style="float:none;margin:auto;">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de catálogos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered" style="text-align:center;" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>Código</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datos as $data)
                        <tr>
                            <td>{{$data->ID_Catalogo}}</td>
                            <td>{{$data->Ubicacion}}</td>
                            <td>
                                    <a class="btn btn-info" href="{{url('/material?id='.$data->ID_Catalogo)}}">
                                        Filtrar
                                    </a>
                                    <a class="btn btn-success" href="#" data-toggle="modal"   data-target="#catalogeditmodal"
                                        onclick="enviardata('{{$data->ID_Catalogo}}')">
                                        Editar
                                    </a>
                                    <a class="btn btn-dark  btn-md" href="{{url('/reportCatalogPDF/'.$data->ID_Catalogo)}}">
                                        <span class="icon text-white-60">
                                        Reporte
                                    </a>
                                    <button class="btn btn-danger btn-flat btn-md remove-material" data-id="{{ $data->ID_Catalogo }}" data-action="{{ route('Material.delete',$data->ID_Catalogo) }}" onclick="deleteConfirmation('{{$data->ID_Catalogo}}')">
                                        <span class="icon text-white-60"> Borrar</span>
                                    </button>    
                            </td>
                            @include('catalog.editcatalog')
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>
</div>


@include('catalog.createcatalog')
<script>
        const forms = document.querySelectorAll('.formActions');
        forms.forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '¿Estas seguro?',
                    text: "El material se eliminará de forma permanente",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            })
        });

    </script>
<script type="text/javascript">
    function enviardata(id) {
        let ID_Catalogo = document.getElementById("ID_Catalogo")
        let Ubicacion = document.getElementById("Ubicacion")
        let form = document.getElementById("form-catalog-edit")
        axios.get('/catalog/' + id).then((e) => {

            ID_Catalogo.value = e.data.ID_Catalogo
            Ubicacion.value = e.data.Ubicacion
            form.action = '/catalog/' + e.data.ID_Catalogo;

        })
    }

</script>

<script>
    function deleteConfirmation(id){
        Swal.fire({
            title: "¿Estás Seguro?",
            html: 'El catálogo: <strong>'+id+'</strong> será eliminado permanentemente',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = "{{ route('Catalog.delete',[':id']) }}";
                url = url.replace(':id', id);
                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                });
                $.ajax({
                    type: 'POST',
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
                                html: 'El catálogo <strong>'+id+'</strong> fué eliminado correctamente',
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
                            var errores = JSON.stringify(results.error);
                            var test = errores.substr(28,39);
                            Toast.fire({
                                icon: 'error',
                                html: '<strong>El catalogo '+id+' '+test+'</strong>',
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

@endsection

