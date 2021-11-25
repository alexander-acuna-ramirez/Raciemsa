@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DETALLE VALE DE ENTRADA</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="ID_Catalogo">Codigo</label>
                        <input type="text" class="form-control" disabled name="ID_Catalogo" id="ID_Catalogo" value="{{ $voucher->ID_vale_entrada }}">
                    </div>
                    <div class="col-md-3">
                        <label for="Codigo_guia_remision">Guia de remisión</label>
                        <input type="text" class="form-control" disabled name="Codigo_guia_remision" id="Codigo_guia_remision" value="{{ $voucher->Codigo_guia_remision }}">
                    </div>
                    <div class="col-md-3">
                        <label for="Hora">Hora de Ingreso</label>
                        <input type="text" class="form-control" disabled name="Hora" id="Hora" value="{{ $voucher->Hora }}">
                    </div>
                    <div class="col-md-3">
                        <label for="Fecha">Fecha de Ingreso</label>
                        <input type="text" class="form-control" disabled name="Fecha" id="Fecha" value="{{ $voucher->Fecha_recepcion }}">
                    </div>

                </div>
                <div class="row">
                    <div class="table-responsive px-3">
                        <table class=" mt-2 table table-bordered" style="text-align:center;">
                            <thead>
                                <th width="20%">
                                    Nro. Parte
                                </th>
                                <th width="30%">
                                    Descripcion
                                </th>
                                <th width="10%">
                                    Cantidad
                                </th>
                                <th width="30%">
                                    Observacion
                                </th>
                                <th width="5%">
                                    Status
                                </th>
                                <th width="5%">
                                    Ubicaciones
                                </th>
                            </thead>
                            <tbody>
                                @foreach($entries as $entry)
                                    <tr>
                                        <td>{{$entry->Numero_de_parte}}</td>
                                        <td>{{$entry->Descripcion}}</td>
                                        <td>{{$entry->Cantidad_recibida}}</td>
                                        <td>{{$entry->Observacion}}</td>
                                        @if($entry->Status == "1")
                                            <td>{{"Correcto"}}</td>
                                        @else
                                            <td>{{"Incorrecto"}}</td>
                                        @endif
                                        <td>
                                            <button class="btn btn-primary" onclick="showLocations('{{$entry->Numero_de_parte}}')">
                                                <i class="fas fa-map-marker-alt"></i>
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
    </div>
@endsection
@section('js')
    <script>
        function showLocations(code){
            axios.get('/searchLocationsEntries/'+code).then((res)=>{
                if(res.status == 200){
                    //console.log(res.data);
                    //res.data.map((e)=>console.log(e));
                    console.log(prepareTable(res.data));
                    Swal.fire({
                        title: `<strong>Ubicaciones para <u>${code}</u></strong>`,
                        icon: 'info',
                        html:prepareTable(res.data),
                        showCloseButton: true,
                        focusConfirm: false,
                        confirmButtonText:
                            '<i class="fa fa-thumbs-up"></i> Ok!',
                        confirmButtonAriaLabel: 'Thumbs up, great!',
                        cancelButtonAriaLabel: 'Thumbs down'
                    })
                }
            })

        }
        function prepareTable(data){
            let tableHeader = `
                            <table class=" mt-2 table table-bordered" style="text-align:center;">
                                <thead>
                                    <th width=30%">
                                        Anaquel
                                    </th>
                                    <th width="20%">
                                        Parte
                                    </th>
                                    <th width="20%">
                                        Piso
                                    </th>
                                    <th width="30%">
                                        Particion
                                    </th>
                                </thead>
                            <tbody>`
            let tableEntries = data.map((e)=>{
                return `<tr><td>${e.Anaquel}</td>
                 <td>${e.Parte_anaquel}</td>
                 <td>${e.Piso}</td>
                 <td>${e.Particion}</td></tr>`
            });
            let endTable = `</tbody></table>`
            return tableHeader + tableEntries +endTable;
        }

    </script>
@endsection
