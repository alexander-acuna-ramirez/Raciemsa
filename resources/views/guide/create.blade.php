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
        <h1 class="h3 mb-0 text-gray-800">Guía de Remisión</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Crear guía</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url("/guide")}}" class="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label for="Codigo_guia_remision">Código</label>
                            <input type="text" class="form-control" value="{{ old('Codigo_guia_remision') }}"
                            name="Codigo_guia_remision" id="Codigo_guia_remision">
                        </div>
    
                        <div class="col-6">
                            <label for="Fecha_de_emision">Fecha de emisión</label>
                            <input type="date" class="form-control" value="{{ old('Fecha_de_emision') }}"
                            name="Fecha_de_emision" id="Fecha_de_emision">
                        </div>

                        <div class="col-6">
                            <label for="Inicio_traslado">Inicio de traslado</label>
                            <input type="date" class="form-control" value="{{ old('Inicio_traslado') }}"
                            name="Inicio_traslado" id="Inicio_traslado">
                        </div>

                        <div class="col-6">
                            <label for="Fin_traslado">Fin de traslado</label>
                            <input type="date" class="form-control" value="{{ old('Fin_traslado') }}"
                            name="Fin_traslado" id="Fin_traslado">
                        </div>

                        <div class="col-6">
                            <label for="Codigo_proveedor">Código de proveedor</label>
                            <select class="form-control" id="Codigo_proveedor" name="Codigo_proveedor">
                                <option value="">Seleccione una opción...</option>
                                @foreach($prov AS $provs)
                                    <option value="{{ $provs->Codigo_proveedor }}">
                                        {{ $provs->Codigo_proveedor }} <span>-</span> {{ $provs->Razon_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
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
                                <span class="text">Agregar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection