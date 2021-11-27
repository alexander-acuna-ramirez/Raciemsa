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
                        <input type="date" class="form-control" id="from">
                    </div>
                    <div class="col-md-4">
                        <label>Fecha Fin</label>
                        <input type="date" class="form-control" id="to">
                    </div>
                    <div class="col-md-4">
                        <label> </label>
                        <button class="form-control btn btn-primary" id="btnSearch">
                            <i class="fas fa-search"></i>
                            Buscar
                        </button>
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
                                <th width="5%">N° Parte</th>
                                <th width="30%">Descripción</th>
                                <th width="5%">Cantidad</th>
                                <th width="30%">Observaciones</th>
                                <th width="10%">Vale(ID)</th>
                                <th width="10%">Recepción</th>
                                <th width="10%">Estado</th>
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
        const to = document.getElementById('to');
        const from = document.getElementById('from');
        const btnSearch = document.getElementById('btnSearch');
        const tbodyE = document.getElementById('tbodyData');
        const btnExport = document.getElementById('exportPDF');
        var dataPDF = [];

        btnSearch.addEventListener('click',(event)=>{
           if(to.value == "" || from.value == ""){
               Toast.fire({
                   icon: 'warning',
                   title: 'Llena ambos campos'
               })
           }else{
               let dataSend = {};
               if(new Date(to.value)>new Date(from.value)){
                   dataSend = {to:to.value,from:from.value};
               }else {
                   dataSend = {to:from.value,from:to.value};
               }
               axios.post('/reportEntriesSearch',dataSend).then((res)=>{
                   if(res.status == 200 && res.data.length == 0){
                       Toast.fire({
                           icon: 'warning',
                           title: 'Sin resultados'
                       })
                       exportPDF.disabled = true;
                   }else if(res.status == 200 && res.data.length > 0){
                       Toast.fire({
                           icon: 'success',
                           title: 'Reporte generado'
                       })
                       res.data.forEach((element)=>{
                           tbodyE.innerHTML += `
                                    <tr>
                                        <td>${element.Numero_de_parte}</td>
                                        <td>${element.Descripcion}</td>
                                        <td>${element.Cantidad_recibida}</td>
                                        <td>${(element.Observacion==null)?"Sin Observaciones":element.Observacion}</td>
                                        <td>${element.ID_vale_entrada}</td>
                                        <td>${element.Recepcion}</td>
                                        <td>${(element.Activo == 1) ? "Habilitado" : "Deshabilitado"}</td>
                                    </tr>
                           `;
                           exportPDF.disabled = false;
                           dataPDF = dataSend;
                       })
                   }else {
                       exportPDF.disabled = true;
                       Toast.fire({
                           icon: 'warning',
                           title: 'Error'
                       })
                   }
               })
           }
        });
        btnExport.addEventListener('click',(event)=>{
            axios.get('/reportEntriesPDF?to='+dataPDF.to+'&from='+dataPDF.from,{responseType: 'blob'})
                .then((response) => {
                    window.open(URL.createObjectURL(response.data));
                    //console.log(response);
                })
        })
    </script>
@endsection
