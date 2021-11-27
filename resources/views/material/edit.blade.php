@extends('layouts.master')

@section('content')
<div class="container-fluid">
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        @foreach ($errors->all() as $error )
        <li style="list-style: none">
            {{ $error }}
        </li>
        @endforeach
    </div>
    @endif
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Catalogos</h1>
    </div>
    <div class="col-md-6" style="float:none;margin:auto;">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Editar Material</h6>
            </div>
            <div class="card-body">
                <div>
                    <form action="{{url('/material/'.$material[0]->Numero_de_parte)}}" class="" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                </div>
                <div class="form-group">
                    <div class="form-group">
                        <div class="form-group col-md-12">
                            <label for="Numero_de_parte">Numero de parte</label>
                            <input type="text" class="form-control" name="Numero_de_parte" id="Numero_de_parte" readonly
                                name="Numero_de_parte" value="{{ $material[0]->Numero_de_parte }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="Codigo_sap">Codigo SAP</label>
                            <input type="text" class="form-control" name="Codigo_sap" id="Codigo_sap" readonly
                                name="Codigo_sap" value="{{ $material[0]->Codigo_sap }}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="Descripcion">Descripcion</label>
                            <input type="text" class="form-control" name="Descripcion" id="Descripcion"
                                value="{{ $material[0]->Descripcion }}">
                        </div>
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <label class="input-group-text">Unidad de medida</label>
                            </div>
                            <select class="custom-select" id="Unidad_de_medida" name="Unidad_de_medida">
                                <option selected>{{ $material[0]->Unidad_de_medida }}</option>
                                <option value="UND">Unidad</option>
                                <option value="LTR">Litro</option>
                                <option value="JGO">Juego</option>
                                <option value="GAL">Galones</option>
                            </select>
                        </div>
                        <div class="input-group mb-3 col-md-12">
                            <div class="input-group-prepend">
                                <label class="input-group-text">Código de Catalogo</label>
                            </div>
                            <select class="custom-select" id="ID_Catalogo" name="ID_Catalogo">
                                <option >{{ $material[0]->ID_Catalogo }}</option>
                                @foreach($data AS $datac)
                                <option value="{{ $datac->ID_Catalogo }}">
                                    {{ $datac->ID_Catalogo }} <span>-</span> {{ $datac->Ubicacion }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="col-md-12">
                                <label for="Descripcion">Ubicacion:</label>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Anaquel" name="Anaquel"
                                    id="Anaquel" value="{{ $material[0]->Anaquel }}">
                                <input type="text" class="form-control" placeholder="Parte" name="Parte_anaquel"
                                    id="Parte_anaquel" value="{{ $material[0]->Parte_anaquel }}">
                                <input type="text" class="form-control" placeholder="Piso" name="Piso" id="Piso"
                                    value="{{ $material[0]->Piso }}">
                                <input type="text" class="form-control" placeholder="Partición" name="Particion"
                                    id="Particion" value="{{ $material[0]->Particion }}">
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="Cotizacion">Cotizacion</label>
                            <input type="number" step="0.01" class="form-control" name="Cotizacion" id="Cotizacion"
                                value="{{ $material[0]->Cotizacion }}">
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <a href="{{url()->previous()}}" class="btn btn-danger btn-icon-split float-right mx-1">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-trash"></i>
                                    </span>
                                    <span class="text">Cancelar</span>
                                </a>
                                <button type="submit" class="btn btn-success btn-icon-split float-right mx-1">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span class="text">Guardar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
