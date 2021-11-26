<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export - PDF</title>

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
        #detalle_productos tr:nth-child(even) {
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
            width: 100%;
            margin-bottom: 10px;
        }
        .proveedor{
            margin-left: 25px;

        }
    </style>
</head>
<body class="login-page" style="background: white">

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
                        <div class="">
                            <img src="https://www.raciemsa.com.pe/wp-content/uploads/2021/11/raciemsa-lg-color.png" alt="logo" >
                        </div>
                        </td>
                    </th>
                    
                </tbody>
            </table>
            <div style="margin-bottom: 0px">&nbsp;</div>
            <div class="proveedor">
                <div class="">
                    <h4>Detalle de Solicitud:</h4>
                        @foreach($cab as $data2)
                        <strong>Codigo Solicitud de Reposicion: {{$data2->Codigo_reposicion}}</strong><br>
                        <strong>Fecha: {{$data2->Fecha_solicitud}}</strong><br>
                        @endforeach
                        @foreach($proveed as $data2)
                        <span>Proveedor: {{$data2->Razon_social}}</span> <br>
                        <span>RUC: {{$data2->RUC}}</span><br>
                        <span>Direccion: {{$data2->direcc}}</span><br>
                        <span>Telfono: +51 (54) {{$data2->telef}}</span><br>
                        <span>Email: {{$data2->email}}</span>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="page">
        <table id="factura_detalle">
            <thead>
                <tr>
                    <th width="15%">Numero de Parte</th>
                    <th width="40%">Descripcion</th>
                    <th width="10%">Cantidad</th>
                    <th width="10%">Prioridad</th>
                    <th width="30%">Observaciones</th>
                </tr>
            </thead>
            <tbody id="detalle_productos">
                @foreach($data as $data)
                <tr>
                    @if($data->Priori == "Si")
                    <td><strong>{{$data->Numero_de_parte}}</strong></td>
                    <td><strong>{{$data->Descripcion}}</strong></td>
                    <td><strong>{{$data->Cant}}</strong></td>
                    <td><strong>{{$data->Priori}}</strong></td>
                    <td><strong>{{$data->Observacion}}</strong></td>
                    @else
                    <td>{{$data->Numero_de_parte}}</td>
                    <td>{{$data->Descripcion}}</td>
                    <td>{{$data->Cant}}</td>
                    <td>{{$data->Priori}}</td>
                    <td>{{$data->Observacion}}</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>