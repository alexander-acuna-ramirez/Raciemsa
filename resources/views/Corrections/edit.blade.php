@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Correcciones</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar Correccion</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url("/Corrections/".$Corrections->Codigo_solicitud_correccion)}}" class="" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-5">
                            <label for="Codigo_solicitud_correccion">Codigo</label>
                            <input type="text" class="form-control" readonly name="Codigo_solicitud_correccion" id="Codigo_solicitud_correccion" value="{{ $Corrections->Codigo_solicitud_correccion }}">
                        </div>
    
                        <div class="col-7">
                            <label for="Numero_de_parte">Numero de parte</label>
                            <input type="text" class="form-control" name="Numero_de_parte" id="Numero_de_parte" value={{ $Corrections->Numero_de_parte }}>
                        </div> 
                        <div class="col-5">
                            <label for="Diferencia">Diferencia</label>
                            <input type="text" class="form-control" name="Diferencia" id="Diferencia" value={{ $Corrections->Diferencia }}>
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
                                <span class="text">Guardar</span>
                            </button>

                            

                        </div>

                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection