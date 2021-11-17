@extends('layouts.master')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Vales de entrada</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Crear vale de entrada</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!--<div class="col-md-4 mt-2">
                        <label for="ID_Catalogo">Codigo de vale</label>
                        <input type="text" disabled class="form-control"  name="ID_Catalogo" id="ID_Catalogo">
                    </div>-->
                    <div class="col-md-6 mt-2">
                        <label for="Hora">Hora de Ingreso</label>
                        <input type="time" readonly class="form-control"  name="Hora" id="Hora" value="{{ $time }}">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="Fecha">Fecha de Ingreso</label>
                        <input type="date" class="form-control"  readonly name="Fecha" id="Fecha" value="{{ $date }}">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Buscar guia de remisión</label>
                            <div class="input-group flex-nowrap">
                                <div class="input-group-append" >
                                    <span class="input-group-text bg-primary text-white border-0">GR.</span>
                                </div>
                                <input id="inputGuide" type="text" class="form-control" placeholder="Codigo guia de remisión">
                                <div class="input-group-append">
                                    <button id="searchBtn" class="btn btn-primary border-0" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Fecha">Razon social </label>
                            <input id="Social" type="text" disabled class="form-control" placeholder="">
                        </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Emisión</label>
                            <input id="Emision" type="text" disabled class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Inicio del traslado</label>
                            <input id="Inicio" type="text" disabled class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label >Fin del traslado</label>
                            <input id="Fin" type="text" disabled class="form-control" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Entradas</h6>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        const searchGuide = document.getElementById('searchBtn');
        const guideInput = document.getElementById('inputGuide');
        const social = document.getElementById('Social');
        const EmisionGuide = document.getElementById('Emision');
        const InicioGuide = document.getElementById('Inicio');
        const FinGuide = document.getElementById('Fin');
        searchGuide.addEventListener('click',(e)=>{
            if(guideInput.value == ""){
                Toast.fire({
                    icon: 'warning',
                    title: 'Ingrese el codigo de la guia de remisión'
                })
            }else{
                /*Necesita validacion*/
                axios.get(`/searchGuide/${guideInput.value}`)
                    .then((response)=>{
                        if(response.data.length === 0){
                            Toast.fire({
                                icon: 'warning',
                                title: 'Guia no encontrada'
                            })
                        }else{
                            Toast.fire({
                                icon: 'success',
                                title: 'Guia encontrada'
                            })
                            social.value = response.data[0].Razon_social;
                            EmisionGuide.value = response.data[0].Fecha_de_emision;
                            InicioGuide.value = response.data[0].Inicio_traslado;
                            FinGuide.value = response.data[0].Fin_traslado;
                            guideInput.readOnly = true;
                            searchGuide.disabled = true;
                        }
                    });
            }
        })
    </script>

@endsection
