@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
    </div>
    <div class="card shadow mb-5">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Proveedor</h6>
            </div>
            <div class="card-body">
                    <div class="alert alert-danger d-none" id="alerts">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label for="Razon_Social">Codigo de proveedor </label>
                            <input type="text" class="form-control" id="codProveedor" value='{{$supplier->Codigo_proveedor}}' disabled>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label for="RUC">Numero de RUC</label>
                            <input type="text" class="form-control" placeholder='{{$supplier->RUC}}' disabled>
                        </div>

                        <br>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label for="Razon_Social">Razon Social </label>
                            <input type="text" class="form-control" placeholder='{{$supplier->Razon_social}}' disabled autcomplete="off">
                        </div>
                    </div>
                    <br>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="80%" cellspacing="0" aling="center">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Telefono</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="telefonoBody" >
                                    <td colspan="3">
                                        <button id="btnAddTelefono" class="btn btn-primary form-control" title="Agregar telefono" >
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                    @foreach ($phones as $phone)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $phone->Id_telefono }}" disabled> 
                                        </td>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $phone->Telefono }}"> 
                                        </td>
                                        <td>
                                            <button onclick="deleteTelefono(this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="80%" cellspacing="0" aling="center">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Correo</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="correoBody">
                                    <td colspan="3"> 
                                        <button id="btnAddCorreo" class="btn btn-primary form-control"  title="Agregar correo">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </td>
                                    @foreach ($emails as $email)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $email->Id_correo }}" disabled> 
                                        </td>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $email->Correo }}"> 
                                        </td>
                                        <td>
                                            <button onclick="deleteCorreo(this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="80%" cellspacing="0" aling="center">
                                <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Dirección</th>
                                    <th>Acciones</th>
                                </tr>
                                </thead>
                                <tbody id="direccionBody">
                                    <tr>
                                        <td colspan="3">
                                            <button id="btnAddDireccion" class="btn btn-primary form-control"  title="Agregar direccion">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach ($addresses as $add)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $add->Id_direccion }}" disabled> 
                                        </td>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $add->Direccion }}"> 
                                        </td>
                                        <td>
                                            <button onclick="deleteDireccion(this)" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>


                <div class="row mt-1 float-right">
                    <button class="btn btn-success mx-1" title="Guardar" id="saveEverything">
                        <i class="fas fa-save"></i>
                    </button>
                    <a class="btn btn-danger" title="Cancelar" href="{{url('/supplier')}}">
                        <i class="fas fa-ban"></i>
                    </a>
                </div>

            </div>
        </div>
</div>
@endsection
@section('js')
<script src="{{asset('/js/assets/suppliersEdit.js')}}"></script>
@endsection