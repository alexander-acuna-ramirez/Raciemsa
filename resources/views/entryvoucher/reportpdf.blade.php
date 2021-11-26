<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        p, label, span, table{
            font-family: 'BrixSansRegular';
            font-size: 9pt;
        }
        .h2{
            font-family: 'BrixSansBlack';
            font-size: 16pt;
        }
        .h3{
            font-family: 'BrixSansBlack';
            font-size: 12pt;
            display: block;
            background: #0a4661;
            color: #FFF;
            text-align: center;
            padding: 3px;
            margin-bottom: 5px;
        }
        #page_pdf{
            width: 95%;
            margin: 15px auto 10px auto;
        }

        #factura_head, #factura_cliente, #factura_detalle{
            width: 100%;
            margin-bottom: 10px;
        }
        .logo_factura{
            width: 25%;
        }
        .info_empresa{
            width: 50%;
            text-align: center;
        }
        .info_factura{
            width: 25%;
        }
        .info_cliente{
            width: 100%;
        }
        .datos_cliente{
            width: 100%;
        }
        .datos_cliente tr td{
            width: 50%;
        }
        .datos_cliente{
            padding: 10px 10px 0 10px;
        }
        .datos_cliente label{
            width: 75px;
            display: inline-block;
        }
        .datos_cliente p{
            display: inline-block;
        }

        .textright{
            text-align: right;
        }
        .textleft{
            text-align: left;
        }
        .textcenter{
            text-align: center;
        }
        .round{
            border-radius: 10px;
            border: 1px solid #0a4661;
            overflow: hidden;
            padding-bottom: 15px;
        }
        .round p{
            padding: 0 15px;
        }

        #factura_detalle{
            border-collapse: collapse;
        }
        #factura_detalle thead th{
            background: #058167;
            color: #FFF;
            padding: 5px;
        }
        #detalle_productos tr:nth-child(even) {
            background: #ededed;
        }
        #detalle_totales span{
            font-family: 'BrixSansBlack';
        }
        .nota{
            font-size: 8pt;
        }
        .label_gracias{
            font-family: verdana;
            font-weight: bold;
            font-style: italic;
            text-align: center;
            margin-top: 20px;
        }
        .anulada{
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translateX(-50%) translateY(-50%);
        }
    </style>
</head>
<body>
<img class="anulada" src="" alt="Anulada">
<div id="page_pdf">
    <table id="factura_head">
        <tr>
            <td class="logo_factura">
                <h2>
                    <strong>
                        RACIEMSA
                    </strong>
                </h2>
            </td>
            <td class="info_empresa">
                <div>
                    <span class="h2">REPORTE DE VALES DE ENTRADA INGRESADOS({{$to}} -{{$from}})</span>

                </div>
            </td>
            <td class="info_factura">
                <div class="round">
                    <span class="h3">Vale de entrada</span>
                    <p>Hora: {{$hora}}</p>
                    <p>Fecha: {{$curdate}}</p>
                </div>
            </td>
        </tr>
    </table>

    <table id="factura_detalle">
        <thead>
        <tr>
            <th width="10%">N° Parte</th>
            <th width="20%">Descripción</th>
            <th width="5%">Cantidad</th>
            <th width="30%">Observacion</th>
            <th width="10%">Vale(ID)</th>
            <th width="10%">Recepcion</th>
            <th width="10%">Estado</th>
        </tr>
        </thead>
        <tbody id="detalle_productos">
        @foreach($entries as $entry)
            <tr>
                <td class="textcenter">{{$entry->Numero_de_parte}}</td>
                <td class="textcenter">{{$entry->Descripcion}}</td>
                <td class="textcenter">{{$entry->Cantidad_recibida}}</td>
                <td class="textcenter">{{$entry->Observacion}}</td>
                <td class="textcenter">{{$entry->ID_vale_entrada}}</td>
                <td class="textcenter">{{$entry->Recepcion}}</td>
                <td class="textcenter">{{$entry->Activo}}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <div>
        <h4 class="label_gracias">¡Gracias por su consulta!</h4>
    </div>

</div>

</body>
</html>
