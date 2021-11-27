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
                            <input type="text" class="form-control" placeholder='{{$supplier->Codigo_proveedor}}' disabled>
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
                                    <th width="100%" colspan="2">Telefono</th>
                                </tr>
                                </thead>
                                <tbody id="telefonoBody" >
                                    @foreach ($phones as $phone)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $phone->Telefono }}" readonly> 
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
                                    <th width="100%" colspan="2">Correo</th>
                                </tr>
                                </thead>
                                <tbody id="correoBody">
                                    @foreach ($emails as $email)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $email->Correo }}" readonly> 
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
                                    <th width="100%" colspan="2">Direccion</th>
                                </tr>
                                </thead>
                                <tbody id="direccionBody">
                                    @foreach ($addresses as $add)
                                    <tr>
                                        <td>
                                            <input type="text" class='form-control' value="{{ $add->Direccion }}" readonly> 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
</div>
@endsection