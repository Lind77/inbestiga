<html>
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <style>
            /** Define the margins of your page **/
            @page {
                margin-top: 170px;
                margin-bottom: 80px;
                margin-left: 0px;
                margin-right: 0px;
            }
            .page-break {
                page-break-after: always;
            }
            header {
                position: fixed;
                top: -180px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                z-index: -1000;

                /** Extra personal styles **/
                width: 100% !important;
            }

            header img{
                width: 100% !important;
            }

            footer {
                position: fixed; 
                bottom: -15px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;
                

                /** Extra personal styles **/
                background-color: #fff;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            footer img{
                width: 100% !important;
            }

            body{
                font-family: 'Montserrat', sans-serif;
                font-size: 12px;
            }
            h1{
                text-align: center;
                font-size: 16px;
            }
            p{
                text-align: justify;
            }
            span{
                font-weight: 700;
            }
            .container{
                padding: 10px 65px 0px 65px;
            }
            ul{
                padding-left: 15px;
            }
            table{
                margin-left: auto;
                margin-right: auto;
            }
            table, th, td {
                border: 1px solid;
                border-collapse: collapse;
                text-align: center;
            }
            td{
                padding: 0px 5px;
            }
            .name{
                font-weight: 400;
                text-transform: uppercase;
            }
            .date-table{
                width: 95%;
            }
            .delivery-table{
                width: 95%;
            }
            .seven-article{
                margin-top: 30px;
            }
            .signatures{
                width: 100%;
                margin-top: 50px;
                display: table;
            }
            .col-signature{
                width: 45%;
                text-align: center;
                display: table-cell;
            }
            .col-signature p{
                text-align: center;
                margin: 0px;
            
            }
            .locator{
                text-align: center;
                margin-top: -35px;
            }
            .client{
                margin-top: 115px;
            }
            .col{
                text-align: center;
            }
            .col-left{
                float: left;
            }
            .col-right{
                float: right;
            }
            .col p{
                text-align: center;
                margin: 0px;
                padding: 0px;
            }
            .second-client{
                padding-top: 200px;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img src="https://inbestiga.com/inbestiga/public/img/contract/contractHeader.png" alt="">
        </header>

        <footer>
            <img src="https://inbestiga.com/inbestiga/public/img/contract/contractFooter.png" alt="">
        </footer>

            <img src="" alt="">

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="container">
                <h1>Adenda de Contrato de locación de servicios</h1>
                <p>Conste por el presente documento, <span>LA ADENDA AL CONTRATO DE LOCACIÓN DE SERVICIOS</span>, celebrado por los mencionados en el contrato principal, que se genera por lo que a continuación se expone. </p>
                <span>PRIMERO: OBJETO DE LA ADENDA AL CONTRATO. </span>
                <p>{{$addendum->object}}</p>
                <span>SEGUNDO: COSTO Y FORMA DEL PAGO.  </span>
                <p>Como contraprestación al servicio prestado por EL LOCADOR, EL CLIENTE se compromete al abono de un monto total de {{ 'S/.'.number_format($addendum->amount) }} ({{strtoupper($addendum->amount_text)}} SOLES), monto que será abonado en las siguientes fechas:</p>
                <table class="date-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto en soles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($addendum->payments as $fee)
                        <tr>
                            <td>{{$fee->date ? date('d/m/Y',strtotime($fee->date)) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{$fee->percentage}}% - S/. {{number_format($fee->amount)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <span>TERCERO: ENTREGAS Y FORMA DE ENTREGAS.  </span>
                <p>Las entregas que EL LOCADOR otorgará a favor de EL CLIENTE serán cargadas al Aula Virtual de EL CLIENTE en los siguientes términos:</p>
                <table class="delivery-table" style="margin-top: -10px;">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Avance</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($addendum->deliveries as $delivery)
                        <tr>
                            <td>
                                @if($delivery->date)
                                    {{ date('d/m/Y', strtotime($delivery->date)) }}
                                    @if($fee->status == 1)
                                    Cancelado
                                    @else
                                    Pendiente
                                    @endif
                                @else
                                    Bajo coordinación con gerencia o tesista
                                @endif
                            </td>
                            <td>{{$delivery->advance}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>{{$addendum->clausule}}</p>
                <p style="visibility: hidden">{{setlocale(LC_TIME, "spanish");}}</p>
                <p style="margin-top: -50px;">Las partes declaran haber leído la adenda del contrato, por lo que conocen y aceptan todas las cláusulas en su integridad, ambos firman el {{strftime('%d de %B de %Y',strtotime($addendum->date))}}. </p>
                <div class="signatures">
                    <div class="col-signature">
                        <img src="https://inbestiga.com/inbestiga/public/img/contract/firmaBere.jpg" width="200">
                        <div class="locator">
                            <p>__________________________</p>
                            <p>EL LOCADOR</p>
                            <p>Representante Legal</p>
                        </div>
                    </div>
                    @php
                        $customers = $addendum->addendumable->quotation->customers;
                        $customerCount = count($customers);
                    @endphp
                    @if($customerCount == 1)
                    <div class="col-signature">
                        <div class="locator" style="padding-top: 150px">
                            <p>__________________________</p>
                            <p>EL ASESORADO</p>
                            <p>{{ $customers[0]->name }}</p>
                        </div>
                    </div>
                    @else
                    <div class="col-signature">
                        <div class="locator" style="padding-top: 195px">
                            <p>__________________________</p>
                            <p>EL ASESORADO</p>
                            <p>{{ $customers[0]->name }}</p>
                        </div>
                    </div>
                    <div style="display: table-row;">
                        @for ($x = 1; $x < $customerCount; $x++)
                                <div class="col-signature">
                                    <div class="locator" style="padding-top: 195px">
                                        <p>__________________________</p>
                                        <p>EL ASESORADO</p>
                                        <p>{{ $customers[$x]->name }}</p>
                                    </div>
                                </div>
                                @endfor
                    </div>
                    @endif
                </div>
        </main>
    </body>
</html>