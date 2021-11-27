@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vales de entrada</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Crear vale de entrada</h6>
            </div>
            <div class="card-body">
                    <div class="alert alert-danger d-none" id="alerts">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="Hora">Hora de Ingreso</label>
                            <input type="time" readonly class="form-control"  name="Hora" id="Hora" value="{{ $time }}">
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="Fecha">Fecha de Ingreso</label>
                            <input type="date" class="form-control"  readonly name="Fecha" id="Fecha" value="{{ $date }}">
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Buscar guia de remisión</label>
                                <div class="input-group flex-nowrap">
                                    <input id="inputGuide" type="text" name="Codigo_guia_remision" class="form-control" placeholder="Codigo guia de remisión">
                                    <div class="input-group-append">
                                        <button id="searchBtn" class="btn btn-primary border-0" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Social">Proveedor </label>
                                <input id="Social" type="text" disabled class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Emisión</label>
                                <input id="Emision" type="text" disabled class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Inicio del traslado</label>
                                <input id="Inicio" type="text" disabled class="form-control" placeholder="">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Fin del traslado</label>
                                <input id="Fin" type="text" disabled class="form-control" placeholder="">
                            </div>
                        </div>
                    </div>
                <div class="row mt-1">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="20%">Número de Parte</th>
                                <th width="30%">Descripción</th>
                                <th width="10%">Cantidad</th>
                                <th width="30%">Observaciones</th>
                                <th width="5%">Status</th>
                                <th width="5%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-1 float-right">
                    <button id="addEntry" class="btn btn-primary" title="Agregar entrada">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="btn btn-success mx-1" title="Guardar" id="saveDetails">
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
    <script src="{{asset('/js/assets/Entries.js')}}"></script>
@endsection
