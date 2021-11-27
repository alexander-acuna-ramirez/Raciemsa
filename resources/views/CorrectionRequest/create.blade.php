@extends('layouts.master')
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes de Corrección</h1>       
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Crear Solicitud de Correción</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url('/CorrectionRequest')}}" class="" method="post">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error )
                                <li style="list-style: none">
                                    {{ $error }}
                            </li>
                            @endforeach
                        </div>
                    @endif
                    <div class="row">                        
                        <div class="col-6 mt-1">
                                <label for="Codigo_solicitud_correccion">Código de Corrección</label>
                                <input type="text" class="form-control"  readonly name="Codigo_solicitud_correccion" id="Codigo_solicitud_correccion" placeholder="SC00000*">
                            </div>
        
                            <div class="col-6 mt-1">
                                <label for="Codigo_reposicion">Código de reposición</label>
                                <input type="text" class="form-control"  name="Codigo_reposicion" id="Codigo_reposicion" >
                            </div>
                        </div>

                    <div class="row"> 
                        <div class="col-6 mt-1">
                            <label for="Motivo">Motivo</label>
                                <input type="text" class="form-control"  name="Motivo" id="Motivo" >
                        </div>

                        <div class="col-6 mt-1">
                            <label for="Fecha">Fecha</label>
                                <input type="date" class="form-control"  name="Fecha" id="Fecha" value="{{$currentDate}}">
                                @error('name')
                                    <br>
                                        <small>{{$message}}</small>
                                    <br>
                                @enderror
                        </div>  
                    </div> 

                        <div class="row">
                            <div class="col-md-6 mt-1">
                                <div class="form-group">
                                    <label>Buscar guía de remisión</label>
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

                            <div class="col-md-6 mt-1">
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

                     </div>     
                    <div>
                        <h1> </h1>
                    </div>
                    <div class="card  mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Correciones</h6>
                    </div>
                    <div class="card-body">

                    <div class="row mt-1">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="25%">Número de Parte</th>
                                <th width="25%">Descripción</th>
                                <th width="25%">Diferencia</th>
                                <th width="25%">Acciones</th>                                
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-1 float-right">
                    <a id="addCorrections" class="btn btn-primary" title="Agregar corrección">
                        <i class="fas fa-plus"></i>
                    </a>
                    <button class="btn btn-success mx-1" title="Guardar" id="saveDetails">
                        <i class="fas fa-save"></i>
                    </button>
                    <a class="btn btn-danger" title="Cancelar" href="{{url('/CorrectionRequest')}}">
                        <i class="fas fa-ban"></i>
                    </a>
                </div>         
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('/js/assets/Corrections.js')}}"></script>
@endsection