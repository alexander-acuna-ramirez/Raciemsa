@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reporte para guía de remisión</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Consulta para guías por material</h6>
        </div>
        <div class="card-body">
            <div> 
                <form type="GET" action="{{ url('/downloadPDF') }}">
                    @csrf
                    <div class="input-group">
                        <div class="col-3">
                            <label for="Codigo_guia_remision">Código de guía</label>
                            <input type="text" class="form-control" aria-label="Search" aria-describedby="basic-addon2"
                            name="CodGuia" id="CodGuia">
                        </div>
    
                        <div class="col-3">
                            <label for="Fecha_de_emision">Mes de consulta</label>
                            <input type="date" class="form-control" aria-label="Search" aria-describedby="basic-addon2"
                            name="FecEmis" id="FecEmis">
                        </div>

                        <div class="col-6" style="padding:30px;padding-bottom:15px;padding-top:10px;">
                            <a href="{{url()->previous()}}" class="btn btn-primary btn-icon-split float-right mx-1">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-circle-left"></i>
                                </span>
                                <span class="text">Volver</span>
                            </a>
                            <button class="btn btn-danger btn-icon-split float-right mx-3" type="submit">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-alt text-white-50"></i>
                                </span>
                                <span class="text">Imprimir</span>
                            </button>
                        </div>
                        <div class="col-12" style="padding-right:30px;">
                            <a class="btn btn-danger btn-icon-split float-right mx-1" href="{{route('downloadPDFall')}}">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-alt text-white-50"></i>
                                </span>
                                <span class="text">Reporte de todas las guías</span>
                            </a>
                        </div>
                    </div>
                </form>
                </form>
            </div>
        </div>
        
    </div>
</div>
@endsection