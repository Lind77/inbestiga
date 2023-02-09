<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Cotización Inbestiga</title>
    <style>
        body{
            font-family: 'Montserrat', sans-serif;
        }
        .bg-purple{
            background-color: #6E26F7;
            border-radius: 0px 0px 10px 10px;
        }
        .main-logo{
            width: 300px;
        }
        .header-text{
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            margin: 0px;
        }
        .name-customer{
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            color: #6E26F7;
            font-size: 14px;
            text-align: left;
            margin-bottom: 0;
            margin-top: 2px;
        }
        .name-customer span{
            color: #000;
        }
        .info-user{
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #6E26F7;
            font-size: 12px;
            margin-bottom: 0;
            margin-top: 2px;
        }
        .name{
            font-weight: 900;
        }
        th span{
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: #000;
            padding: 0px 0px 0px 10px;
            display: inline-block;
        }
        .main-table tr:nth-child(even) {
            background-color: #6f26f71a;
        }
        table, th{
            /* border: 1px solid #000; */
        }
        .customer-data{
            /* border: 1px solid #000; */
        }
        .customer-data tr, th{
           /*  border: 1px solid #000; */
            vertical-align:top;
        }
        .info-doc{
            font-weight: 700;
        }
        .info-doc-p{
            margin: 0px !important;
        }
        .sub-header{
            margin-top: 10px;
            font-weight: 700;
        }
        .text-purple{
            color: #6E26F7;
        }
        .main-table{
            width: 100%;
        }
        .main-table thead{
            background-color: #6f26f71a;
            font-weight: 700;
        }
        .table-item{
            font-weight: 4 fw-30000;
            border: 1px solid #6E26F7;
        }
        .sugested{
            font-weight: 900;
        }
        .sugested-title{
            background-color: #6f26f71a;
        }
        .pig-text{
            font-weight: 700;
        }
        .pig-text span{
            color: #6E26F7;
        }
        .last{
            position: absolute;
            bottom: 0;
        }
        .watermark{
            position: absolute;
            top: 28%;
            left: 30%;
            width: 40%;
            z-index: -1;
        }
        footer{
            background-color: #6f26f71a;
            color: #000;
            font-size: 15px;
            font-weight: 700;
            padding: 15px 18px 15px 18px;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-purple">
        <div class="row w-100 px-4 py-3">
            <div class="col-6 d-flex align-items-center justify-content-center">
                <img src="https://inbestiga.com/pdf-sys/logo.png" alt="" class="main-logo">
            </div>
            <div class="col-6">
                <p class="header-text">Prol. Cuzco 921 Huancayo.</p>
                <p class="header-text">Elías Aguirre N° 180 - 3er Piso - Miraflores - Lima</p>
                <p class="header-text">www.inbestiga.com</p>
                <p class="header-text">991 045 555</p>
            </div>
        </div>
    </nav>
    <section class="row">
        <div class="col-8 ps-5 pt-4">
            <table class="customer-data">
                <tbody>
                    <tr>
                        <th><h2 class="name-customer">COTIZACIÓN DE: </h2></th>
                        <th><span class="name">JULY MENDOZA</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Teléfono: </h2></th>
                        <th><span>942 450 894</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Carrera o mención: </h2></th>
                        <th><span>Mg. Salud Pública</span></th>
                    </tr>
                    <tr>
                        <th><h2 class="info-user">Universidad: </h2></th>
                        <th><span>Universidad Nacional del Centro del Perú</span></th>
                    </tr>
                </thead>
            </table>
            <p class="sub-header">Elaboración completa de Tesis: <span class="text-purple">Posgrado</span></p>
        </div>
        <div class="col-4 info-doc pt-3">
            <p class="info-doc-p">COTIZACIÓN N°: 01-EN-VL</p>
            <p class="info-doc-p">FECHA: 09-01-2023</p>
            <p class="info-doc-p">VALIDEZ: 16-01-2023</p>
            <p class="info-doc-p">IMPORTE: S./3930.00</p>
        </div>
    </section>
    <section class="d-flex justify-content-center">
        <table class="main-table">
            <thead>
                <tr>
                    <th class="text-purple fw-bolder py-3 ps-2">PRODUCTO / SERVICIO</th>
                    <th class="text-purple fw-bolder py-3 ps-1">DESCRIPCIÓN</th>
                    <th class="text-purple fw-bolder py-3 ps-1">PLAZO</th>
                    <th class="text-purple fw-bolder py-3 ps-1">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th class="table-item fw-normal ps-2">ASPECTOS PRELIMINARES</th>
                    <th class="table-item fw-normal">
                        -Matriz de consistencia.<br>
                        -Descripción del problema.<br>
                        -Problemas.<br>
                        -Objetivos.<br>
                        -Justificación.<br>
                        -Delimitación.<br>
                    </th>
                    <th class="table-item fw-normal">- 02 Semanas</th>
                    <th class="table-item fw-normal">S./990.00</th>
                </tr>
                <tr>
                    <th class="table-item fw-normal ps-2">MARCO TEÓRICO</th>
                    <th class="table-item fw-normal">
                        -Antecedentes de Investigación.<br>
                        -Bases teóricas.<br>
                        -Definición de términos.<br>
                    </th>
                    <th class="table-item fw-normal">- 02 Semanas</th>
                    <th class="table-item fw-normal">S./990.00</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th class="text-purple">TOTAL</th>
                    <th class="text-purple">S./3990.00</th>
                </tr>
                <tr class="sugested-title">
                    <th class="text-purple sugested py-3 ps-1" colspan="4">PRODUCTO SUGERIDO</th>
                </tr>
                <tr style=" background-color: #ffffff00;">
                    <th class="table-item fw-normal ps-2">MARCO TEÓRICO</th>
                    <th class="table-item fw-normal">
                        -Antecedentes de Investigación.<br>
                        -Bases teóricas.<br>
                        -Definición de términos.<br>
                    </th>
                    <th class="table-item fw-normal">- 02 Semanas</th>
                    <th class="table-item fw-normal">S./990.00</th>
                </tr>
                <tr style=" background-color: #ffffff00;">
                    <th></th>
                    <th></th>
                    <th class="text-purple">TOTAL</th>
                    <th class="text-purple">S./3990.00</th>
                </tr>
                <tr class="sugested-title">
                    <th class="text-purple sugested py-3 ps-1" colspan="4">PRECIO FINAL</th>
                </tr>
                <tr style=" background-color: #fff;">
                    <th></th>
                    <th></th>
                    <th class="text-purple">TOTAL</th>
                    <th class="text-purple">S./3990.00</th>
                </tr>
                <tr style=" background-color: #fff;">
                    <th></th>
                    <th></th>
                    <th class="text-danger">DESCUENTO</th>
                    <th class="text-danger">S./0000.00</th>
                </tr>
            </tbody>
        </table>
    </section>
    <section class="last">
        <div class="row mt-3">
            <div class="col-6 ps-5 d-flex justify-content-center align-items-center">
                <img src="https://inbestiga.com/pdf-sys/pig.png" class="w-25">
                <p class="ps-3 pig-text">Recuerda que puedes hacer el pago en <span>CUOTAS</span>!</p>
            </div>
            <div class="col-6"></div>
        </div>
        <footer class="mt-3">
            <p>Gracias por brindarnos tu confianza. Contáctanos si tienes alguna duda acerca de esta cotización.</p>
        </footer>
    </section>
    <img src="https://inbestiga.com/pdf-sys/watermark.png" class="watermark">
    <script>
        window.print()
    </script>
</body>
</html>