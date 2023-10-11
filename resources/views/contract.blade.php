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
                bottom: -10px; 
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
                padding: 0px 120px;
                margin-top: 140px;
            }
            .locator{
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
            <img src="https://inbestiga.com/pdf-sys/contract/contractHeader.png" alt="">
        </header>

        <footer>
            <img src="https://inbestiga.com/pdf-sys/contract/contractFooter.png" alt="">
        </footer>

            <img src="" alt="">

        <!-- Wrap the content of your PDF inside a main tag -->
        <main>
            <div class="container">
                <h1>Contrato de locación de servicios</h1>
                <p>Conste por el presente documento, <span>EL CONTRATO DE LOCACIÓN DE SERVICIOS</span>, (en adelante “<span>EL CONTRATO</span>”) que, en virtud al artículo 1764º y siguientes del Código Civil peruano, celebran de una parte:</p>
                <ul>
                    <li style="text-align: justify">
                        INBESTIGA SOCIEDAD ANÓNIMA CERRADA, empresa identificada con RUC No. 20609545535, 
                        con domicilio para estos efectos en Calle Elías Aguirre 180º, distrito de Miraflores y provincia de Lima; a quien en adelante se le denominará como “EL LOCADOR”.</li>
                        Y, de la otra parte:
                        
                    <li>@if(count($contract->quotation->customers) > 1)
                        @foreach($contract->quotation->customers as $customer)
                        <span class="name">{{$customer->name}}</span>, identificado con DNI No. {{$customer->dni}}, con domicilio para estos efectos en {{$customer->address}} {{$loop->last?'':'y'}}
                        @endforeach
                        ; a quienes en adelante se les denominará como “EL ASESORADO”.
                        @else
                        <span class="name">{{$contract->quotation->customers[0]->name}}</span>, identificado con DNI No. {{$contract->quotation->customers[0]->dni}}, con domicilio para estos efectos en {{$contract->quotation->customers[0]->address}} ; a quien en adelante se le denominará como “EL ASESORADO”.
                        @endif
                    </li>
                </ul>
                <p>
                    <span>EL LOCADOR</span> y <span>EL ASESORADO</span> podrán ser denominados de manera conjunta como “<span>LAS PARTES</span>” o de 
                manera individual como “<span>LA PARTE</span>”. <span>EL CONTRATO</span> es celebrado por <span>LAS PARTES</span> en los términos y condiciones siguientes:
                </p>
                <p>
                    <span>PRIMERO: OBJETO DEL CONTRATO.</span><br>
                EL CONTRATO se celebra con el objeto de que EL LOCADOR entregue a favor de EL ASESORADO un producto académico según los parámetros del contrato y la observancia del reglamento de la {{$contract->quotation->customers[0]->university}} y la carrera o mención de {{$contract->quotation->customers[0]->career}} - N{{$contract->quotation->details[0]->level}}.
                </p>
                <p>
                    <span>SEGUNDO: OBLIGACIONES DEL LOCADOR.</span><br>
                EL LOCADOR se compromete a cumplir con lo siguiente:
                <ul style="margin-top: -15px;">
                    @if($contract->third_article != 1)
                        <li>
                            Proporcionar la información de aplicación de instrumentos.
                        </li>
                    @endif
                    @if($contract->third_article_place != 1)
                        <li>
                            Proporcionar información sobre el lugar de estudio, la población y muestra
                        </li>
                    @endif
                    <li>Entregar productos originales que garanticen bajos niveles de similitud con respecto de otros trabajos de investigación.
                    </li>
                    <li>
                        Levantar las observaciones advertidas por los revisores universitarios hasta la obtención del informe que aprueba la sustentación.
                    </li>
                    <li>
                        Ceder los derechos de propiedad intelectual a favor de EL ASESORADO, para los fines que este considere pertinentes.
                    </li>
                    <li>
                        No divulgar los datos de EL ASESORADO, salvo necesidad inexcusable o solicitud propia del mismo.
                    </li>
                    <li>
                        No utilizar el producto académico para fines que no sean los estipulados en EL CONTRATO.
                    </li>
                </ul>
                </p>
                
                <p>
                    <span>TERCERO: OBLIGACIONES DEL ASESORADO.</span><br>
                    EL ASESORADO se compromete a cumplir con lo siguiente:
                    <ul style="margin-top: -15px;">
                        @if($contract->third_article == 1)
                        <li>
                            Proporcionar la información de aplicación de instrumentos.
                        </li>
                        @endif
                        @if($contract->third_article_place == 1)
                        <li>
                            Proporcionar información sobre el lugar de estudio, la población y muestra
                        </li>
                        @endif
                        <li>
                            Proporcionar al departamento académico la información y documentos necesarios para la prestación del servicio.
                        </li>
                        <li>
                            Comunicarse dentro del horario de oficina y mediante Whatsapp o correo electrónico.
                        </li>
                        <li>
                            Otorgar observaciones únicamente advertidas por el asesor universitario o los jurados revisores.
                        </li>
                        <li>
                            Atender a las recomendaciones de departamento académico sobre la comunicación con asesor y jurados universitarios.
                        </li>
                        <li>
                            Abonar los pagos establecidos de manera puntual y únicamente mediante los medios de pago oficiales descritos en la cláusula cuarta.
                        </li>
                    </ul>
                </p>
                <p style="margin-top: 15px;">
                    <span>CUARTO: COSTO Y FORMA DEL PAGO.</span><br>
                Como contraprestación al servicio prestado por EL LOCADOR, EL ASESORADO se compromete al abono de un monto total de
                @if($contract->cent_text == null) 
                <span>S/.{{number_format($contract->amount)}} <span class="name">({{$contract->amount_text}} soles)</span></span>
                @else
                <span>S/.{{number_format($contract->amount, 1)}}0 
                    <span class="name">({{$contract->amount_text}} soles
                        @if($contract->cent_text != 'cero')
                        con {{$contract->cent_text}} céntimos)
                        @endif
                    </span>
                </span>
                @endif, monto que será abonado en las siguientes fechas:
                </p>
                <table class="date-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto en soles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contract->payments as $fee)
                        <tr>
                            <td>{{$fee->date ? date('d/m/Y',strtotime($fee->date)) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{$fee->percentage}}% - S/. {{$fee->amount}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <p>El pago será abonado bajo las siguientes modalidades:</p>
                <table style="margin-top: 20px;">
                    <thead>
                        <tr>
                            <th>Banco</th>
                            <th>Moneda</th>
                            <th>Titular y número de cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>BCP</td>
                            <td>Soles</td>
                            <td>Inbestiga SAC Nº 355-9862526-0-30 <br> CCI: 00235500986252603066</td>
                        </tr>
                        <tr>
                            <td rowspan="2">Interbank</td>
                            <td>Soles</td>
                            <td>Inbestiga SAC Nº 500-3004188829 <br> CCI: 00350000300418882965</td>
                        </tr>
                        <tr>
                            <td>Dólares</td>
                            <td>Inbestiga SAC N° 500-3004188836</td>
                        </tr>
                        <tr>
                            <td>BBVA</td>
                            <td>Soles</td>
                            <td>Inbestiga SAC Nº 0011-0235-0201838132</td>
                        </tr>
                        <tr>
                            <td>Yape</td>
                            <td>Soles</td>
                            <td>Inbestiga SAC – 926708058</td>
                        </tr>
                    </tbody>
                </table>
                <ul>
                    <li> Efectivo: Estrictamente abonado en las oficinas de la empresa.</li>
                    <li> Depósito o transferencia bancaria: </li>
                </ul>
               {{--  <div class="page-break"></div> --}}
                <span>QUINTO: ENTREGAS Y FORMA DE ENTREGAS.</span>
                <p style="margin-top: -8px;">Las entregas que EL LOCADOR otorgará a favor de EL ASESORADO serán cargadas al correo y/o grupo de WhatsApp creado en los siguientes términos: </p>
                <table class="delivery-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Avance</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($contract->projects[0]->deliveries as $delivery)
                        <tr>
                            <td>{{$delivery->date ? date('d/m/Y',strtotime($delivery->date)) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{$delivery->advance}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 @if($contract->fifth_article == 1)
                    <p style="margin-top: -5px;">Además, EL LOCADOR se compromete con entregar a favor de EL ASESORADO los siguientes beneficios adicionales:
                    </p>
                    <ul style="margin-top: -8px;">
                        <li>Asesoría de preparación metodológica y temática sobre la investigación para la sustentación.</li>
                        <li>Ebook / guía de sustentación escrita.</li>
                        <li>Balotario de preguntas de sustentación.</li>
                        <li>Plantilla de diapositivas en Power Point para la sustentación</li>
                        <li>Reporte de Turnitin.</li>
                    </ul>
                    @endif
                    <div class="page-break"></div>
                <span>SEXTO: EXCLUSIVIDAD</span>
                <p>En virtud de esta cláusula, el contrato suscrito se establece exclusivamente entre EL LOCADOR y EL ASESORADO. Cualquier ampliación relacionada al alcance del servicio que incluya a otras personas requiere una notificación y adenda escrita, junto con la aceptación de los términos y costos adicionales por ambas partes. "El asesorado" asume la responsabilidad total de los pagos adicionales relacionados con cualquier extensión del servicio. "El locador" se reserva el derecho de rechazar dicha ampliación sin consentimiento previo por escrito. Esta cláusula garantiza la transparencia y evita malentendidos en caso de cambios en el alcance de los servicios. Ambas partes aceptan estos términos mediante la firma del contrato.</p>

                <span style="margin-top: 0px;">SÉPTIMO: SOBRE LA RESOLUCIÓN DEL CONTRATO</span>
                <p>Si existe un acuerdo de LAS PARTES para la resolución del contrato, este podrá ser resuelto sin consecuencias jurídicas que perjudiquen a las mismas.
                En caso de que EL LOCADOR incumpla sus obligaciones sin que exista una justificación suficiente que haya 
                escapado a su voluntad, este deberá reintegrar a EL ASESORADO, el total de los pagos abonados por este 
                último.
                En caso de que EL ASESORADO manifieste la intención de resolver el contrato, este deberá adjuntar mediante 
                correo electrónico medios probatorios suficientes que justifiquen su solicitud, la cual será evaluada por la 
                gerencia de EL LOCADOR. Bajo ninguna circunstancia, la resolución del contrato a pedido de EL ASESORADO 
                conllevará a devolución de los pagos abonados hasta el momento de aprobación o denegación de la 
                solicitud; pagos utilizados para la cobertura de gastos operativos, logísticos, administrativos y de 
                mercadotecnia. </p>
                {{-- <div class="page-break"></div> --}}
                <span class="seven-article">OCTAVO: MORA INDEMNIZATORIA Y PENALIDADES.</span>
                <p>
                    8.1. Sobre los pagos<br>
                    EL ASESORADO tendrá una prórroga de hasta 2 días calendario para abonar los montos descritos en la cláusula 
                    cuarta de EL CONTRATO. A partir del tercer día calendario siguiente al vencimiento de la fecha de pago, EL 
                    ASESORADO deberá abonar una mora indemnizatoria de S/.15.00 (quince soles) por cada día que no ha 
                    realizado el pago, lo cual tendrá efecto retroactivo desde el primer día de incumplimiento de pago.<br>
                    8.2. Sobre la resolución de contrato a pedido de parte<br>
                    En caso de que EL ASESORADO manifieste la intención de resolver el presente contrato, sin que ello esté contenido en la descripción de la cláusula sexta, este deberá pagar a favor de EL LOCADOR un monto 
                    indemnizatorio por incumplimiento de obligaciones contraprestativas que ascenderá a un 20% del monto 
                    total que EL ASESORADO estuviera pendiente de abonar, según el cronograma de la cláusula cuarta de EL 
                    CONTRATO.<br>
                    8.3. Sobre las entregas<br>
                    EL LOCADOR tendrá una prórroga de hasta dos días hábiles para la entrega de los avances contenidos en la 
                    cláusula quinta de EL CONTRATO. En caso de que EL LOCADOR cumpla tardíamente y sin justificación 
                    razonable con la entrega, EL ASESORADO tendrá la posibilidad de exigir un reembolso de S/15.00 (quince soles) 
                    diarios por cada día de retraso en la entrega del producto académico correspondiente.
                </p>
                <div class="page-break"></div>
                <span>NOVENO: CONFIDENCIALIDAD </span>
                <p>EL LOCADOR se compromete a mantener en reserva todos los datos de EL ASESORADO, incluso después de que las demás obligaciones de EL CONTRATO se hayan extinguido; a excepción de aquellos casos que la ley exija lo contrario.</p>
               
                <span>DECIMO: GARANTÍA DEL SERVICIO</span><br>
                <p>EL CONTRATO no tiene una cláusula de prescripción de obligaciones por parte de EL LOCADOR  que se rija 
                    por el tiempo, sino que las obligaciones de este se extinguen únicamente cuando EL ASESORADO haya obtenido 
                    el informe aprobatorio de los tres jurados revisores de la tesis.
                    EL ASESORADO asume la responsabilidad sobre todo tipo de negligencia que pudiera aparecer en el producto 
                    académico, cuando esta es ocasionada por sí mismo, esto es, cuando la información proporcionada por EL 
                    ASESORADO es ilegítima, incorrecta, o influenciada por terceras personas ajenas al vínculo contractual o 
                    personal universitario. </p>
                    {{-- <div class="page-break"></div> --}}
                <span>DÉCIMO PRIMERO: SANCIONES</span><br>
                <p> En caso de que EL ASESORADO muestre conductas hostiles hacia cualquier miembro de la organización, este 
                    perderá automáticamente todos los beneficios adicionales contenidos en EL CONTRATO. Además, en caso el 
                    servicio no contenga beneficios adicionales, se sancionará a EL ASESORADO con un bono excedente de hasta 
                    S/.50.00 (cincuenta soles).</p>
                <span>DÉCIMO SEGUNDO: SOLUCIÓN DE CONFLICTOS</span><br>
                <p>En caso de desacuerdo durante la ejecución del presente contrato, estos deberán solucionarlo mediante 
                    conciliación extrajudicial.
                    En caso de presentarse cualquier asunto dudoso o litigioso derivado de la interpretación, aplicación o 
                    ejecución del presente contrato, las partes se someterán al fuero arbitral de la Cámara de Comercio de Lima 
                    según desee el interesado.</p> 
                <span>DÉCIMO TERCERO: BONIFICACIONES</span><br>
               <p>En caso de que EL ASESORADO refiera a EL LOCADOR y este celebre un contrato de índole similar a la del 
                    presente contrato, EL LOCADOR otorgará a EL ASESORADO una bonificación de S/.60.00 (sesenta soles) por cada 
                    mil soles de ingreso con los que la empresa se vea beneficiada.</p>
                    <p style="visibility: hidden">{{setlocale(LC_TIME, "spanish");}}</p>
                    <div class="page-break"></div>
                    <p>Las partes declaran haber leído el contrato, por lo que conocen y aceptan todas las cláusulas en su integridad, ambos firman el {{strftime('%d de %B de %Y',strtotime($contract->date))}}</p>
                <div class="signatures">
                    <div class="col col-left">
                        <img src="https://inbestiga.com/pdf-sys/firmaBere.jpg" width="200">
                        <div class="locator">
                            <p>__________________________</p>
                            <p>EL LOCADOR</p>
                            <p>Representante Legal</p>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($contract->quotation->customers)>2)
                            @foreach($contract->quotation->customers as $customer)
                            <div class="col">
                                <div class="client">
                                    __________________________<br>
                                    EL ASESORADO <br>
                                    {{$customer->name}}
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>