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
            
            header {
                position: fixed;
                top: -170px;
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
                bottom: -30px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                font-size: 20px !important;

                /** Extra personal styles **/
                background-color: #008B8B;
                color: white;
                text-align: center;
                line-height: 35px;
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
                margin-top: 180px;
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
        </style>
    </head>
    <body>
        <!-- Define header and footer blocks before your content -->
        <header>
            <img src="https://inbestiga.com/pdf-sys/header.png" alt="">
        </header>

        <footer>
            <img src="https://inbestiga.com/pdf-sys/footer.png" alt="">
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
                    <li>
                        <span class="name">{{$customer->name}}</span>, identificado con DNI No. {{$customer->dni}}, con domicilio para estos efectos en {{$customer->address}}; a quien en adelante se le denominará como “EL CLIENTE”.
                    </li>
                </ul>
                <p>
                    <span>EL CLIENTE</span> y <span>EL LOCADOR</span> podrán ser denominados de manera conjunta como “<span>LAS PARTES</span>” o de 
                manera individual como “<span>LA PARTE</span>”. <span>EL CONTRATO</span> es celebrado por <span>LAS PARTES</span> en los términos y condiciones siguientes:
                </p>
                <p>
                    <span>PRIMERO: OBJETO DEL CONTRATO.</span><br>
                EL CONTRATO se celebra con el objeto de que EL LOCADOR entregue a favor de EL CLIENTE un producto 
                académico según los parámetros de EL CONTRATO.
                </p>
                <p>
                    <span>SEGUNDO: OBLIGACIONES DEL LOCADOR.</span><br>
                EL LOCADOR se compromete a cumplir con lo siguiente:
                <ul>
                    <li>Entregar productos originales que garanticen bajos niveles de similitud con respecto de otros trabajos de investigación.
                    </li>
                    <li>
                        Levantar las observaciones advertidas por los revisores universitarios hasta la obtención del informe que aprueba la sustentación.
                    </li>
                    <li>
                        Ceder los derechos de propiedad intelectual a favor de EL CLIENTE, para los fines que este considere pertinentes.
                    </li>
                    <li>
                        No divulgar los datos de EL CLIENTE, salvo necesidad inexcusable o solicitud propia del mismo.
                    </li>
                    <li>
                        No utilizar el producto académico para fines que no sean los estipulados en EL CONTRATO.
                    </li>
                </ul>
                </p>
                <p>
                    <span>TERCERO: OBLIGACIONES DEL CLIENTE.</span><br>
                    EL CLIENTE se compromete a cumplir con lo siguiente:
                    <ul>
                        @if($customer->quotations[0]->contract->third_article == 1)
                        <li>
                            Proporcionar la información de aplicación de instrumentos.
                        </li>
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
                <p>
                    <span>CUARTO: COSTO Y FORMA DEL PAGO.</span><br>
                Como contraprestación al servicio prestado por EL LOCADOR, EL CLIENTE se compromete al abono de un 
                monto total de S/{{$customer->quotations[0]->contract->amount}} (<span class="name">{{$customer->quotations[0]->contract->amount_text}}</span> soles), monto que será abonado en las siguientes fechas:
                </p>
                <table class="date-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto en soles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->quotations[0]->contract->payments as $fee)
                        <tr>
                            <td>{{$fee->date ? date('d/m/Y',strtotime($fee->date)) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{$fee->percentage}}% - S/ {{$fee->amount}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                El pago será abonado bajo las siguientes modalidades:
                <table style="margin-top: 15px;">
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
                <span>QUINTO: ENTREGAS Y FORMA DE ENTREGAS.</span><br>
                <p>Las entregas que EL LOCADOR otorgará a favor de EL CLIENTE serán cargadas al correo y/o grupo de WhatsApp creado en los siguientes términos: </p>
                <table class="delivery-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Avance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customer->quotations[0]->contract->deliveries as $delivery)
                        <tr>
                            <td>{{$delivery->date ? date('d/m/Y',strtotime($delivery->date)) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{$delivery->advance}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($customer->quotations[0]->contract->fifth_article == 1)
                <p>Además, EL LOCADOR se compromete con entregar a favor de EL CLIENTE los siguientes beneficios adicionales:
                </p>
                <ul>
                    <li>Asesoría de preparación metodológica y temática sobre la investigación para la sustentación.</li>
                    <li>Ebook / guía de sustentación escrita.</li>
                    <li>Balotario de preguntas de sustentación.</li>
                    <li>Plantilla de diapositivas en Power Point para la sustentación</li>
                    <li>Reporte de Turnitin.</li>
                </ul>
                @endif
                <span>SEXTO: SOBRE LA RESOLUCIÓN DEL CONTRATO</span><br>
                <p>Si existe un acuerdo de LAS PARTES para la resolución del contrato, este podrá ser resuelto sin consecuencias jurídicas que perjudiquen a las mismas.
                En caso de que EL LOCADOR incumpla sus obligaciones sin que exista una justificación suficiente que haya 
                escapado a su voluntad, este deberá reintegrar a EL CLIENTE, el total de los pagos abonados por este 
                último.
                En caso de que EL CLIENTE manifieste la intención de resolver el contrato, este deberá adjuntar mediante 
                correo electrónico medios probatorios suficientes que justifiquen su solicitud, la cual será evaluada por la 
                gerencia de EL LOCADOR. Bajo ninguna circunstancia, la resolución del contrato a pedido de EL CLIENTE 
                conllevará a devolución de los pagos abonados hasta el momento de aprobación o denegación de la 
                solicitud; pagos utilizados para la cobertura de gastos operativos, logísticos, administrativos y de 
                mercadotecnia. </p>
                <br>
                <span class="seven-article">SÉPTIMO: MORA INDEMNIZATORIA Y PENALIDADES.</span><br>
                <p>
                    7.1. Sobre los pagos<br>
                    EL CLIENTE tendrá una prórroga de hasta 2 días calendario para abonar los montos descritos en la cláusula 
                    cuarta de EL CONTRATO. A partir del tercer día calendario siguiente al vencimiento de la fecha de pago, EL 
                    CLIENTE deberá abonar una mora indemnizatoria de S/.15.00 (quince soles) por cada día que no ha 
                    realizado el pago, lo cual tendrá efecto retroactivo desde el primer día de incumplimiento de pago.<br>
                    7.2. Sobre la resolución de contrato a pedido de parte<br>
                    En caso de que EL CLIENTE manifieste la intención de resolver el presente contrato, sin que ello esté
                            
                    contenido en la descripción de la cláusula sexta, este deberá pagar a favor de EL LOCADOR un monto 
                    indemnizatorio por incumplimiento de obligaciones contraprestativas que ascenderá a un 20% del monto 
                    total que EL CLIENTE estuviera pendiente de abonar, según el cronograma de la cláusula cuarta de EL 
                    CONTRATO.<br>
                    7.3. Sobre las entregas<br>
                    EL LOCADOR tendrá una prórroga de hasta dos días hábiles para la entrega de los avances contenidos en la 
                    cláusula quinta de EL CONTRATO. En caso de que EL LOCADOR cumpla tardíamente y sin justificación 
                    razonable con la entrega, EL CLIENTE tendrá la posibilidad de exigir un reembolso de S/15.00 (quince soles) 
                    diarios por cada día de retraso en la entrega del producto académico correspondiente.
                </p>
                <span>OCTAVO: CONFIDENCIALIDAD </span><br>
                <p>EL LOCADOR se compromete a mantener en reserva todos los datos de EL CLIENTE, incluso después de que las demás obligaciones de EL CONTRATO se hayan extinguido; a excepción de aquellos casos que la ley exija lo contrario.</p>
                <span>NOVENO: GARANTÍA DEL SERVICIO</span><br>
                <p>EL CONTRATO no tiene una cláusula de prescripción de obligaciones por parte de EL LOCADOR  que se rija 
                    por el tiempo, sino que las obligaciones de este se extinguen únicamente cuando EL CLIENTE haya obtenido 
                    el informe aprobatorio de los tres jurados revisores de la tesis.
                    EL CLIENTE asume la responsabilidad sobre todo tipo de negligencia que pudiera aparecer en el producto 
                    académico, cuando esta es ocasionada por sí mismo, esto es, cuando la información proporcionada por EL 
                    CLIENTE es ilegítima, incorrecta, o influenciada por terceras personas ajenas al vínculo contractual o 
                    personal universitario. </p>
                <span>DÉCIMO: SANCIONES</span><br>
                <p> En caso de que EL CLIENTE muestre conductas hostiles hacia cualquier miembro de la organización, este 
                    perderá automáticamente todos los beneficios adicionales contenidos en EL CONTRATO. Además, en caso el 
                    servicio no contenga beneficios adicionales, se sancionará a EL CLIENTE con un bono excedente de hasta 
                    S/50.00 (cincuenta soles).</p>
                <span>DÉCIMO PRIMERO: SOLUCIÓN DE CONFLICTOS</span><br>
                <p>En caso de desacuerdo durante la ejecución del presente contrato, estos deberán solucionarlo mediante 
                    conciliación extrajudicial.
                    En caso de presentarse cualquier asunto dudoso o litigioso derivado de la interpretación, aplicación o 
                    ejecución del presente contrato, las partes se someterán al fuero arbitral de la Cámara de Comercio de Lima 
                    según desee el interesado.</p> 
                <span>DÉCIMO SEGUNDO: BONIFICACIONES</span><br>
               <p>En caso de que EL CLIENTE refiera a EL LOCADOR y este celebre un contrato de índole similar a la del 
                    presente contrato, EL LOCADOR otorgará a EL CLIENTE una bonificación de S/60.00 (sesenta soles) por cada 
                    mil soles de ingreso con los que la empresa se vea beneficiada.</p>
                    <p style="visibility: hidden">{{setlocale(LC_TIME, "spanish");}}</p>
                    <p>Las partes declaran haber leído el contrato, por lo que conocen y aceptan todas las cláusulas en su integridad, ambos firman el {{strftime('%d de %B de %Y',strtotime($customer->quotations[0]->contract->date))}}</p>
                <div class="signatures">
                    <div class="col col-left">
                        <img src="https://inbestiga.com/pdf-sys/firmaBere.jpg" width="200">
                        <div class="locator">
                            <p>__________________________</p>
                            <p>EL LOCADOR</p>
                            <p>Representante Legal</p>
                        </div>
                    </div>
                    <div class="col col-right">
                        <div class="client">
                        <p>__________________________</p>
                        <p>EL CLIENTE</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>