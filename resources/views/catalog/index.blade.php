@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>
    

        <div class="d-sm-flex align-items-center justify-content-between mb-4 ">
            <h1 class="h3 mb-0 text-gray-800">Catalogos</h1>


            <a class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" href="#" data-toggle="modal"
                data-target="#catalogaddmodal"><i class="fas fa-plus-circle text-white-50"></i> Crear catalogo </a>
        </div>
 <!--Search-->

 <nav class="navbar navbar-light ">
        <form class="form-inline ">
            <input name="buscarCatalog" class="form-control mr-sm-2 typeahead" type="search" placeholder="Codigo Catalogo"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>

        <div class="col-md-8" style="float:none;margin:auto;">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de catalogos</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" style="text-align:center;" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Ubicacion</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datos as $data)
                                <tr>
                                    <td>{{$data->ID_Catalogo}}
                                        
                                    </td>
                                    <td>{{$data->Ubicacion}}</td>
                                    <td>

                                        <form action="{{url('/catalog/'.$data->ID_Catalogo)}}" method="post"
                                            class="formActions">
                                            <a class="btn btn-info" href="{{url('/material?id='.$data->ID_Catalogo)}}">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                            <a class="btn btn-success" href="#" data-toggle="modal"
                                                data-target="#catalogeditmodal"
                                                onclick="enviardata('{{$data->ID_Catalogo}}')">Editar</a>
                                            @csrf
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-danger " value="Borrar">
                                                Borrar
                                            </button>

                                        </form>


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



@endsection

