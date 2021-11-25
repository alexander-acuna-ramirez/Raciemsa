@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Solicitudes de Correccion</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar solicitud de correccion</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url('/CorrectionRequest/'.$CorrectionRequest->Codigo_solicitud_correccion)}}" class="" method="post" id="frmEditar">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-4">
                            <label for="Codigo_solicitud_correccion">Codigo</label>
                            <input type="text" class="form-control" readonly name="Codigo_solicitud_correccion" id="Codigo_solicitud_correccion" value="{{ $CorrectionRequest->Codigo_solicitud_correccion }}">
                        </div>
    
                        <div class="col-4">
                            <label for="Codigo_reposicion">Codigo reposicion</label>
                            <input type="text" class="form-control" readonly name="Codigo_reposicion" id="Codigo_reposicion" value={{ $CorrectionRequest->Codigo_reposicion }}>
                        </div> 
                        <div class="col-4">
                            <label for="Codigo_guia_remision">Guia de remision</label>
                            <input type="text" class="form-control" readonly name="Codigo_guia_remision" id="Codigo_guia_remision" value={{ $CorrectionRequest->Codigo_guia_remision }}>
                        </div>
                        <div class="col-4">
                            <label for="Motivo">Motivo</label>
                            <input type="text" class="form-control" name="Motivo" id="Motivo" value={{ $CorrectionRequest->Motivo}}>
                        </div>
                        <div class="col-4">
                            <label for="Fecha">Fecha</label>
                            <input type="date" class="form-control" name="Fecha" id="Fecha" value={{ $CorrectionRequest->Fecha }}>
                        
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
                        </div>
                        
                    </div>

                    
                    <div class="row mt-2">
                        <div class="col">
                            <div class="col">
                                <button type='submit' class="btn btn-success mx-1 float-right mx-1" title="Guardar" id="saveDetails" >
                                    <i class="fas fa-save"></i>
                                </button>
                                <a class="btn btn-danger float-right mx-1" title="Cancelar" href="{{url('/CorrectionRequest')}}">
                                    <i class="fas fa-ban"></i>
                                </a>                         
                            </div>
                        </div>
                    </div>                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection