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
                        <table class=" mt-2 table table-bordered">
                            <thead>
                                <th>
                                    Nro. Parte
                                </th>
                                <th>
                                    Descripcion
                                </th>
                                <th>
                                    Cantidad
                                </th>
                                <th>
                                    Observacion
                                </th>
                                <th>
                                    Status
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
