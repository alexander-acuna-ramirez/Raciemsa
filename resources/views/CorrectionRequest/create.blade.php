@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes de Correccion</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Crear solicitud de correccion</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url("/CorrectionRequest")}}" class="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <label for="Codigo_solicitud_correccion">Codigo</label>
                            <input type="text" class="form-control"  name="Codigo_solicitud_correccion" id="Codigo_solicitud_correccion" >
                        </div>
    
                        <div class="col-5">
                            <label for="Codigo_reposicion">Codigo de reposición</label>
                            <input type="text" class="form-control"  name="Codigo_reposicion" id="Codigo_reposicion" >
                        </div>

                        <div class="col-5">
                            <label for="Codigo_guia_remision">Guia de remision</label>
                            <input type="text" class="form-control"  name="Codigo_guia_remision" id="Codigo_guia_remision" >
                        </div>


                        <div class="col-5">
                            <label for="Motivo">Motivo</label>
                            <input type="text" class="form-control"  name="Motivo" id="Motivo" >
                        </div>

                        <div class="col-5">
                            <label for="Fecha">Fecha</label>
                            <input type="date" class="form-control"  name="Fecha" id="Fecha" value="{{ $Next }}">
                        </div>
                       
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
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