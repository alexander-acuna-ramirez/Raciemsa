@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-2">
                <h6 class="m-0 font-weight-bold text-primary "> Informacion del Proveedor</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="Codigo_proveedor">Codigo del proveedor:</label>
                        <input type="text" class="form-control" disabled name="Codigo_proveedor" id="Codigo_proveedor" value="{{ $supplier->Codigo_proveedor}}">                       
                    </div>
                    <div class="col-md-5">
                        <label for="Razon_social">Nombre o Razon Social del proveedor: </label>
                        <input type="text" class="form-control" disabled name="Razon_social" id="Razon_social" value="{{ $supplier->Razon_social }}">
                    </div>
                    <div class="col-md-4">
                        <label for="RUC">Numero de RUC del proveedor: </label>
                        <input type="text" class="form-control" disabled name="RUC" id="RUC" value="{{ $supplier->RUC }}">
                        <br>
                    </div>
                    <div class="col-md-5">
                        <label for="Email">Correo Electronico del proveedor: </label>
                        <tbody type="text" class="form-contro l">
                            @foreach($email as $email)
                                <tr>
                                    <input type="text " class="form-control" disabled name="Correo" id="Correo" value="{{ $email->Correo }}">    
                                </tr>
                            @endforeach
                        </tbody>
                    </div>

                    <div class="col-md-6">
                        <label for="Direccion">Direccion del proveedor: </label>
                        <tbody type="text" class="form-contro l">
                            @foreach($address as $address)
                                <tr>
                                    <input type="text " class="form-control" disabled name="Direccion" id="Direccion" value="{{ $address->Direccion }}">    
                                </tr>
                            @endforeach
                        </tbody>             
                    </div>

                    <div class="col-md-7">
                        <label for="Telefono">Telefono del proveedor: </label>
                        <table class="table table-borderless">
                            <tbody type="text" class="form-contro l">
                                @foreach($phone as $phone)
                                    <tr>
                                        <input type="text " class="form-control" disabled name="Telefono" id="Telefono" value="{{ $phone->Telefono }}">    
                                    </tr>
                                @endforeach
                            </tbody>    
                        </table>
                                                  
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection