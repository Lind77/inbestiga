<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inbestiga - Cotización</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }
        body{
            font-family: 'Montserrat', sans-serif;
            background: url('https://www.jairpl.com/inbestiga/markwater.png') ;
            background-position: top 140px;
            background-size: 100% auto;
            background-repeat: no-repeat;
        }
        .header{
            width: 100%;
            
        }
        .general-data{
            width: 220px;
            margin-top: -110px;
            margin-left: 70%;
            color: #fff;
            line-height: 16px;
            font-size: 20px;
            font-style: italic;
            font-family: 'Montserrat', sans-serif;
        }
        .second-section{
            background-color: rgba(121, 121, 121, 0.074);
            width: 100%;
            height: 70px;
            padding: 10px 0px 10px 0px;
        }
        .col-3{
            float: left;
            width: 40%;
        }
        .col{
            float: left;
            width: 50%;
        }
        .pl-2{
            padding-left: 10px;
        }
        .name{
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 400;
            color: #6e26f7;
            margin-left: 5%;
        }
        .name span{
            color: #000;
        }
        .third-section-subtitle{
            font-family: 'Montserrat', sans-serif;
            font-size: 20px;
            font-weight: 400;
            color: #000;
            margin-left: 30px;
        }
        .third-section-subtitle span{
            color: #6e26f7;
        }
        table{
            margin-top: 10px;
            width: 100%;
            padding: 0px 30px 0px 30px;
            border-collapse: collapse;
        }
        thead{
            background-color: #6e26f7;
            color: #fff;
        }
        th{
            text-align: left;
            margin: 0px;
            padding: 3px 0px 3px 5px;
        }
        .row-table-body{
            padding: 14px 0px 14px 0px;
        }
        tr>td{
            width: 25%;
            padding: 10px 5px 10px 5px;
            border-bottom: 1px solid #000;
            font-weight: 200;
        }
        .title{
            text-transform: uppercase;
            padding-right: 15px;
        }
        .description{
            width: 40%;
            padding-left: 20px;
            padding-right: 10px;
            font-size: 15px;
            white-space: pre-line;
            line-height: 15px;
        }
        .description-head{
            padding-left: 20px;
        }
        .table-footer{
            margin: 10px 30px 0px 30px;
            padding: 5px 10px 5px 10px;
            background-color: #6e26f7;
            color: #fff;
            font-weight: 600;
            font-style: italic;
            font-size: 20px;
            text-align: right;
        }
        .table-footer span{
            padding-left: 10px;
        }
        .total{
            border-top: 2px solid #6e26f7;
            text-align: right;
            margin: 10px 30px 0px 550px;
            color: #6e26f7;
            font-weight: 600;
            font-size: 20px;
        }
        .thanks{
            color: #6e26f7;
            font-size: 13px;
            margin-left: 330px;
            margin-right: 5px;
            font-weight: 200;
        }
        .footer{
            position: absolute;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <img class="header" src="https://www.jairpl.com/inbestiga/header.png">
    <div class="general-data">
        <p>Cotización N°: {{$quotation->id}}</p>
        <p>Fecha: {{$quotation->date}}</p>
        <p>Importe: S./ {{$quotation->amount}}</p>
    </div>
    <div class="second-section">
        <div class="col-3 pl-2">
            <p class="name">Cotización de: <span>{{$customer->name}}</span></p>
            <p class="name">Teléfono: <span>{{$customer->cell}}</span></p>
        </div>
        <div class="col">
            <p class="name">Carrera profesional: <span>{{$customer->career}}</span></p>
            <p class="name">Universidad: <span>{{$customer->university}}</span></p>
        </div>
    </div>

    <div class="third-section">
        <p class="third-section-subtitle">Elaboración completa de Tesis:  
            <span>
                @if($customer->grade == 1)
                Pregrado
                @elseif($customer->grade == 2)
                Maestría
                @elseif($customer->grade == 3)
                Doctorado
                @endif
            <span>
        </p>

        <table>
            <thead>
                <tr>
                    <th>PRODUCTO/SERVICIO</th>
                    <th class="description-head">DESCRIPCIÓN</th>
                    <th>PLAZO</th>
                    <th>TOTAL</th>
                </tr>    
            </thead>
            <tbody>
                @foreach($details as $detail)
                <tr class="row-table-body">
                    <td class="title">{{$detail->product->title}}</td>
                    <td class="description">{{$detail->product->description}}</td>
                    <td>{{$detail->product->term}}</td>
                    <td>S./ {{$detail->product->amount}}</td>
                </tr>
                @endforeach
            </tbody>     
        </table>
        <div class="table-footer">
                    FINANCIAMIENTO APROBADO<span></span>
        </div>
        <p class="total">Total S./{{$quotation->amount}}</p>
        <p class="thanks">Gracias por darnos su confianza. Por favor contáctenos si usted tiene cualquier consulta o duda acerca de esta cotización.</p>       
    </div>
   
    <img class="footer" src="https://www.jairpl.com/inbestiga/footer.png">
</body>
</html>