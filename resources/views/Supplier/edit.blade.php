@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Editar Proveedor</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url("/supplier/".$supplier->Codigo_proveedor)}}" class="" method="post">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="row">
                        <div class="col-5">
                            <label for="Codigo_proveedor">Codigo del proveedor</label>
                            <input type="text" class="form-control" readonly name="Codigo_proveedor" id="Codigo_proveedor" value="{{ $supplier->Codigo_proveedor }}">
                        </div>
    
                        <div class="col-7">
                            <label for="Razon_social">Razon Social</label>
                            <input type="text" class="form-control" name="Razon_social" id="Razon_Social" value="{{ $supplier->Razon_social }}">
                            @error('name')
                                <br>
                                    <small>{{$message}}</large>
                                <br>
                            @enderror
                        </div>
                        
                        <div class="col-5">
                            <label for="RUC">Numero de RUC</label>
                            <input type="text" class="form-control" name="RUC" id="RUC" value="{{ $supplier->RUC }}">
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