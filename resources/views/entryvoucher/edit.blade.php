@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vales de entrada</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Editar vale de entrada</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="ID_vale_entrada">Vale de entrada (ID)</label>
                        <input type="text" disabled class="form-control"  name="ID_vale_entrada" id="ID_vale_entrada" value="{{ $cabecera->ID_vale_entrada }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="Hora">Hora de Ingreso</label>
                        <input type="time" disabled class="form-control"  name="Hora" id="Hora" value="{{ $cabecera->Hora }}">
                    </div>
                    <div class="col-md-4 mt-2">
                        <label for="Fecha">Fecha de Ingreso</label>
                        <input type="date" class="form-control"  disabled name="Fecha" id="Fecha" value="{{ $cabecera->Fecha_recepcion }}">
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Guia de remisión</label>
                            <input id="inputGuide" disabled type="text" name="Codigo_guia_remision" class="form-control" value="{{ $cabecera->Codigo_guia_remision }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Social">Proveedor </label>
                            <input id="Social" type="text" disabled class="form-control" value="{{$cabecera->Razon_social}}">
                        </div>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="20%">Numero de Parte</th>
                                <th width="30%">Descripcion</th>
                                <th width="10%">Cantidad</th>
                                <th width="30%">Observaciones</th>
                                <th width="5%">Status</th>
                                <th width="5%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($cuerpo as $entrada)
                                    <tr>
                                        <td><input name='codigo' class='form-control' disabled type='text' value="{{$entrada->Numero_de_parte}}"></td>
                                        <td><input name='Descripcion' class='form-control' disabled type='text' value="{{$entrada->Descripcion}}"></td>
                                        <td><input name='Cantidad'  class='form-control' type='number' value="{{$entrada->Cantidad_recibida}}"></td>
                                        <td><input name='Observaciones'  class='form-control' type='text' value="{{$entrada->Observacion}}"></td>
                                        <td><input name='status'  class='form-control' type='checkbox' @if($entrada->Status == 1) checked @endif></td>
                                        <td><button class='btn btn-danger' onclick='deleteEntry(this)'><i class='fas fa-trash'></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-1 float-right">
                    <button class="btn btn-success mx-1" title="Guardar" id="saveChanges">
                        <i class="fas fa-save"></i>
                    </button>
                    <a class="btn btn-danger" title="Cancelar" href="{{url('/entryvoucher')}}">
                        <i class="fas fa-ban"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('/js/assets/EntriesEdit.js')}}"></script>
@endsection
