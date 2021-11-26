@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">GENERADOR DE REPORTES DE ENTRADAS</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label>Fecha Inicio</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Fin</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label> </label>
                        <button class="btn btn-primary">
                            <i class="fas fa-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
