@extends('layouts.master')

@section('content')
<!--Material-->
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{$Title}}</h1>
        <a href="{{url('/material/create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-plus-circle text-white-50"></i> Crear Material </a>
    </div>

    <!--Search-->

    <nav class="navbar navbar-light ">
        <form class="form-inline" type="GET" action="{{ url('/searchMaterialsap') }}">
            <input name="buscarNParte" class="form-control mr-sm-2" type="search" placeholder="Número de Parte"
                aria-label="Search">
                <input name="buscarsap" id="buscarsap" class="form-control mr-sm-2" type="search" placeholder="Código SAP"
                aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
        </form>
    </nav>


    <div class="card shadow mb-4 ">

        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de materiales</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="text-align:center;"  id="dataTableMaterial" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Número de Parte</th>
                            <th>Código SAP</th>
                            <th>Descripción</th>
                            <th>U. M.</th>                            
                            <th>Ubicación</th>
                            <th>Stock</th>
                            <th>Detalle</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datosM as $dataM)
                        <tr>
                            <td>{{$dataM->Numero_de_parte}}</td>
                            <td>{{$dataM->Codigo_sap}}</td>
                            <td>{{$dataM->Descripcion}}</td>
                            <td>{{$dataM->Unidad_de_medida}}</td>
                            <td>{{$dataM->Ubicacion}}</td>
                            <td>{{$dataM->Stock}}</td>
                            <td><button value="{{$dataM->Numero_de_parte}}" id="showMaterial" 
                                onclick='showMaterial(this)' class="btn btn-info">
                                    <i class="fas fa-eye"></i>
                                </button></td>
                                <td>                                                        
                                <a class="btn btn-success" href="{{url('/material/'.$dataM->Numero_de_parte)}}">
                                    <i class="fas fa-edit"></i>
                                 </a>
                                 <button class="btn btn-danger btn-flat btn-md remove-material" data-id="{{ $dataM->Numero_de_parte }}" data-action="{{ route('Material.delete',$dataM->Numero_de_parte) }}" onclick="deleteConfirmation('{{$dataM->Numero_de_parte}}')">
                                    <span class="icon text-white-60">
                                    <i class="fa fa-trash" aria-hidden="true"></i></span>
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
    function deleteConfirmation(numparte){
        Swal.fire({
            title: "¿Estás Seguro?",
            html: 'El material: <strong>'+numparte+'</strong> será eliminado permanentemente',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, eliminar',
            cancelButtonText: 'Cancelar'
        }).then(function (e) {
            if (e.value === true) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = "{{ route('Material.delete',[':id']) }}";
                url = url.replace(':id', numparte);
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
                                html: 'El material <strong>'+numparte+'</strong> fue eliminado correctamente',
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
                                html: '<strong>El material '+numparte+' '+test+'</strong>',
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
                    const forms = document.querySelectorAll('.formActionsMaterial');
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
                <script>
    const boton = document.querySelectorAll("#showMaterial");
    console.log("a");
    function showMaterial(element){
        axios.get("showMaterial/"+element.value).then((response)=>{
            if(response.status===200 && response.data.length>0){
                Swal.fire({
                    icon: 'info',
                    title: 'Detalles del material:',
                    html:
    "<div ><strong>Código de catálogo: </strong>"+response.data[0].ID_Catalogo +"<br> <strong>Cotización: </strong>"+response.data[0].Cotizacion+" <strong>Total: </strong>"+response.data[0].Total+" </div>"
                       
                })
            }
        }) 
    }
</script>

@endsection
