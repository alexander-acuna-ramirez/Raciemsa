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
            <td class="info_empresa">
                <div>
                    <h2>RACIEMSA S.A.</h2><br>
                    <a class="h4">Reporte de las guías de remisión con todos los materiales que contienen</a>
                </div>
            </td>
            <td class="info_factura">
                <div class="round">
                    <span class="h3">Datos de la empresa</span>
                    <p>Razón social: <strong>Racionalización Empresarial S.A.</strong></p>
                    <p>Dirección: Carretera Variante de Uchumayo Km. 5.5 - Alto Cural Cerro Colorado.</p>
                    <p>Teléfono: +51 (54) 383970</p>
                    <p>Email: consultas@raciemsa.com.pe</p>
                    <p>Arequipa, Perú</p>
                </div>
            </td>
        </tr>
    </table>
    <!--
    <table id="factura_cliente">
        <tr>
            <td class="info_cliente">
                <div class="round">
                    <span class="h3">Cliente</span>
                    <table class="datos_cliente">
                        <tr>
                            <td><label>Nit:</label><p>54895468</p></td>
                            <td><label>Teléfono:</label> <p>7854526</p></td>
                        </tr>
                        <tr>
                            <td><label>Nombre:</label> <p>Angel Arana Cabrera</p></td>
                            <td><label>Dirección:</label> <p>Calzada Buena Vista</p></td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>-->

    <table id="factura_detalle">
        <thead>
        <tr>
            <th width="20%">RUC</th>
            <th width="10%">Código guía remisión</th>
            <th width="10%">Fecha de emisión</th>
            <th width="40%">Razón social</th>
        </tr>
        </thead>
        <tbody id="detalle_productos">
        @foreach($datos as $dato)
            <tr>
                <td class="textcenter">{{$dato->RUC}}</td>
                <td class="textcenter">{{$dato->Codigo_guia_remision}}</td>
                <td class="textcenter">{{$dato->Fecha_de_emision}}</td>
                <td class="textcenter">{{$dato->Razon_social}}</td>
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