@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-4">
            <h6 class="m-0 font-weight-bold text-primary">Ingresar datos del nuevo Proveedor</h6>
        </div>
        <div class="card-body">
            <div> 
                <form action="{{url("/supplier")}}" class="" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-5">
                            <label for="Codigo_proveedor">Codigo del Proveedor</label>
                            <input type="text" class="form-control" name="Codigo_proveedor" id="Codigo_proveedor" placeholder="Ingrese el codigo del proveedor" >
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
                            </br>
                        </div>
                        
                        <div class="col-5">
                            <label for="RUC">Numero de RUC</label>
                            <input type="text" class="form-control"  name="RUC" id="RUC" placeholder="Ingrese RUC del proveedor">
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
                        </div>
    
                        <div class="col-10">
                            <label for="Razon_social">Razon Social</label>
                            <input type="text" class="form-control" name="Razon_social" id="Razon_social" placeholder="Ingrese el nombre del proveedor">
                            @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                <br>
                            @enderror
                            </br>
                        </div>

                        <div class="col-5">
                            <label for="Id_telefono">Telefono del proveedor</label>
                            <input type="text" class="form-control" name="Id_telefono" id="Id_telefono" placeholder="Ingrese el telefono del proveedor">
                            @error('name')
                            <br>
                                <large>{{$message}}</largel>
                            </br>
                            @enderror
                        </div>
                        <div class="col-5">
                            <label for="Id_correo">Correo Electronico del proveedor</label>
                            <input type="text" class="form-control" name="Id_correo" id="Id_correo" placeholder="Ingrese el correo electronico del proveedor">
                                @error('name')
                                <br>
                                    <small>{{$message}}</small>
                                </br>
                                @enderror
                                </br>
                        </div>
                        <div class="col-10">
                            <label for="Id_direccion">Direccion</label>
                            <input type="text" class="form-control" name="Id_direccion" id="Id_direccion" placeholder="Ingrese la direccion del proveedor">
                                @error('name')
                                    <br>
                                        <small>{{$message}}</small>
                                    </br>
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