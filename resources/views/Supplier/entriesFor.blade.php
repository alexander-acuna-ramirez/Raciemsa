@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">GENERADOR DE REPORTES DE ENTRADAS</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Buscar codigo proveedor</label>
                        <div class="input-group flex-nowrap">
                            <input id="inputProv" type="text" name="Codigo_guia_remision" class="form-control" placeholder="Codigo proveedor">
                            <div class="input-group-append">
                                <button id="searchBtn" class="btn btn-primary border-0" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label> </label>
                    <button class="form-control btn btn-danger mt-1" id="exportPDF" disabled>
                        <i class="fas fa-file-pdf"></i>
                        Exportar
                    </button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th width="10%">Guia de remisión</th>
                            <th width="10%">Vale de entrada</th>
                            <th width="30%">Descripcion</th>
                            <th width="30%">Cantidad</th>
                            <th width="10%">Unida de medida</th>
                            <th width="10%">Status</th>
                        
                        </tr>
                        </thead>
                        <tbody id="tbodyData">

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        const inputSearch = document.getElementById('inputProv');
        const btnSearch = document.getElementById('searchBtn');
        const btnExport =document.getElementById('exportPDF');
        let tbody = document.getElementById('tbodyData');
        btnExport.addEventListener('click',(event)=>{
            axios.get('/forProvDataPDF?codProv='+inputSearch.value,{responseType: 'blob'})
            .then(function (response) {
                window.open(URL.createObjectURL(response.data));
            });
        })
        btnSearch.addEventListener('click',(event)=>{
           axios.get("/forProvData?codProv='"+inputSearch.value+"'").then((res)=>{
               console.log(res);
               if(res.data.length > 0){
                Swal.fire({
                    icon: 'success',
                    title: 'Ok',
                    text: 'Reporte generado!',
                })
                btnExport.disabled = false;
                res.data.forEach((element)=>{
                    let tr = document.createElement('tr');
                    tbody.innerHTML += 
                    `
                    <tr>
                        <td>${element.Codigo_guia_remision}</td>
                        <td>${element.ID_vale_entrada}</td>
                        <td>${element.Descripcion}</td>
                        <td>${element.Cantidad_recibida}</td>
                        <td>${element.Unidad_de_medida}</td>
                        <td>${(element.Status == 1)?'Correcto':'Incorrecto'}</td>
                    </tr>    
                    `
        
                })
               }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'No se encontro nada'
                })
                btnExport.disabled = true;
                tbody.innerHTML = "";
               }
           })
       })
    </script>
@endsection