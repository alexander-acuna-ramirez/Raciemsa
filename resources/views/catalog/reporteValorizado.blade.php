<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Materials</title>
    <style>
        th,td,tr{
            
        }
        #factura_detalle{
            border-collapse: collapse;
            text-align: center;
        }
        #factura_detalle thead th{
            background: #058167;
            color: #FFF;
            padding: 5px;
        }
        #materiales_de_catalogo tr:nth-child(even) {
            background: #ededed;
        }
        .page{
            width: 95%;
            margin: 15px auto 10px auto;
        }
        #factura_head, #factura_cliente, #factura_detalle{
            width: 100%;
            margin-bottom: 10px;
        }
        .cabec{
            width: 98%;
            margin-bottom: 15px;
            margin-left: 15px;

        }
        .catalogo{
            margin-left: 25px;

        }
        .enc{
            text-align: right;
            margin-right: 18px;
        }
    </style>
</head>
<body>
<div>
    <div class="">
        <div class="">
            <table class="cabec">
                <thead></thead>
                <tbody>
                    <th>
                        <td width="73%">
                            <strong>RACIEMSA S.A.</strong><br>
                            <strong>Razon social: Racionalización Empresarial S.A </strong> <br>
                            Direccion: Carretera Variante de Uchumayo<br>
                            Km 5.5 - Alto Cural Cerro Colodaro<br>
                            Teléfono: +51 (54) 383970<br>
                            Email: consultas@raciemsa.com.pe <br>
                            Arequipa, Perú
                            <br>
                        </td>
                        <td>
                        <div class="enc">
                            <h2>RACIONALIZACIÓN EMPRESARIAL</h2>               
                        </div>
                        </td>
                    </th>
                </tbody>
            </table>
            @foreach($listCat as $data2)
            <div style="margin-bottom: 0px">&nbsp;</div>
            <div class="catalogo">
                <div class="">
                    <span><strong>Reporte Valorado de Catalogo: {{$data2 ->ID_Catalogo}}</strong></span> <br>
                    <span>Ubicacion: {{$data2->Ubicacion}}</span>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="page">
            <table id="factura_detalle">
                <thead>
                    <tr>
                        <th width="20%">Cotizacion</th>
                        <th width="30%">Total de Materiales Registrados</th>
                        <th width="20%">Stock Total</th>
                        <th width="20%">Total de Inventario</th>

                    </tr>
                </thead>
                <tbody id="materiales_de_catalogo">
                    <tr>
                        <td>{{$data2->Cotizacion}}</td>
                        <td>{{$data2->CantMatRegistrados}}</td>
                        <td>{{$data2->StockTotal}}</td>
                        <td>{{$data2->TotalInv}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endforeach

</body>
</html>