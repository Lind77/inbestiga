<template>
    <table>
        <thead>
            <tr>
                <td>
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
    <tbody>
        <tr>
            <td>
        <div class="content">
            <main>
            <div class="container">
                <h1>Contrato de locación de servicios</h1>
                <p style="margin-top: -5px">
                    Conste por el presente documento,
                    <span>EL CONTRATO DE LOCACIÓN DE SERVICIOS</span>, (en
                    adelante “<span>EL CONTRATO</span>”) que, en virtud al
                    artículo 1764º y siguientes del Código Civil peruano,
                    celebran de una parte:
                </p>
                <ul>
                    <li style="text-align: justify">
                        INBESTIGA SOCIEDAD ANÓNIMA CERRADA, empresa identificada
                        con RUC No. 20609545535, con domicilio para estos
                        efectos en Calle Mártir José Olaya 169º Oficina 505,
                        distrito de Miraflores y provincia de Lima; a quien en
                        adelante se le denominará como “EL LOCADOR”.
                    </li>
                    Y, de la otra parte:
                    <li v-if="contract && contract.quotation">
                        <template
                            v-if="contract.quotation.customers.length > 1"
                        >
                            <template
                                v-for="(customer, index) in contract.quotation.customers"
                            >
                                <span class="name">{{ customer.name }}</span
                                >, identificado con DNI No. {{ customer.dni }},
                                con domicilio para estos efectos en
                                {{ customer.address }}
                                <span v-if="index != Object.keys(contract.quotation.customers).length - 1">, </span>
                            </template>
                            ; a quienes en adelante se les denominará como “EL
                            ASESORADO”
                        </template>
                        <template v-else>
                            <div>
                                <span class="name">{{
                                    contract.quotation.customers[0].name
                                }}</span
                                >, identificado con DNI No.
                                {{ contract.quotation.customers[0].dni }}, con
                                domicilio para estos efectos en
                                {{ contract.quotation.customers[0].address }} ;
                                a quien en adelante se le denominará como “EL
                                ASESORADO”.
                            </div>
                        </template>
                    </li>
                </ul>
                <p>
                    <span>EL LOCADOR</span> y <span>EL ASESORADO</span> podrán
                    ser denominados de manera conjunta como “<span
                        >LAS PARTES</span
                    >” o de manera individual como “<span>LA PARTE</span>”.
                    <span>EL CONTRATO</span> es celebrado por
                    <span>LAS PARTES</span> en los términos y condiciones
                    siguientes:
                </p>
                <p v-if="contract && contract.quotation">
                    <span>PRIMERO: OBJETO DEL CONTRATO.</span><br />
                    EL CONTRATO se celebra con el objeto de que EL LOCADOR
                    entregue a favor de EL ASESORADO un producto académico que
                    corresponde a {{ contract.quotation.details[0].name }} según
                    los parámetros del contrato y la observancia del reglamento
                    de la {{ contract.quotation.customers[0].university }} y la
                    carrera o mención de
                    {{ contract.quotation.customers[0].career }} - N{{
                        contract.quotation.details[0].level
                    }}.
                </p>
                <p>
                    <span>SEGUNDO: OBLIGACIONES DEL LOCADOR.</span><br>
                EL LOCADOR se compromete a cumplir con lo siguiente:
                <ul>
                        <li v-if="contract.third_article != 1">
                            Proporcionar la información de aplicación de instrumentos.
                        </li>
                        <li v-if="contract.third_article_place != 1">
                            Proporcionar información sobre el lugar de estudio, la población y muestra
                        </li>
                        <li v-if="contract.third_article_ppts != 1">
                            Realizar las diapositivas para la sustentación, teniendo en consideración la información dada en el trabajo de investigación realizado.
                        </li>
                    <li>Entregar productos originales que garanticen bajos niveles de similitud con respecto de otros trabajos de investigación.
                    </li>
                    
                    <li v-if="contract.fragment != 1">
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
                    <ul>
                        <li v-if="contract.third_article == 1 && contract.fragment != 1">
                            Proporcionar la información de aplicación de instrumentos.
                        </li>
                        <li v-if="contract.third_article_place == 1 && contract.fragment != 1">
                            Proporcionar información sobre el lugar de estudio, la población y muestra
                        </li>
                        <li v-if="contract.third_article_ppts == 1 && contract.fragment != 1">
                            Realizar las diapositivas para la sustentación, teniendo en consideración la información dada en el trabajo de investigación realizado.
                        </li>
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
                <p v-if="contract && contract.amount">
                    <span>CUARTO: COSTO Y FORMA DEL PAGO.</span><br>
                Como contraprestación al servicio prestado por EL LOCADOR, EL ASESORADO se compromete al abono de un monto total de
                {{contract.cent_text == null? `S/${contract.amount}(${upperCaseText(contract.amount_text)} SOLES)`: `S/${contract.amount}0`}}
                {{`(${upperCaseText(contract.amount_text)} SOLES`}} 
                {{contract.cent_text!='cero'? `CON ${upperCaseText(contract.cent_text)} CÉNTIMOS)`:')'}}
                monto que será abonado en las siguientes fechas:
                </p>
                <table class="table date-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Monto en soles</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="fee in contract.payments">
                            <td>{{fee.date ? dateFormatted(fee.date) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{fee.percentage}}% - S/. {{fee.amount}}</td>
                        </tr>
                    </tbody>
                </table>
                <p>El pago será abonado bajo las siguientes modalidades:</p>
                <ul>
                    <li> En efectivo: Exclusivamente en las instalaciones de la empresa, durante las horas hábiles de atención.<span> Beneficios por pago en efectivo:</span> Para pagos en efectivo se hará descuento del 5%.</li>
                    <li> Link de pago: Este método se facilitará mediante plataformas seguras y confiables como Izi Pay y Niubiz, garantizando así la protección de sus datos financieros. El link para el pago se generará y enviará al cliente después de una coordinación previa con el asesor comercial asignado, ofreciendo una solución práctica y segura para realizar su pago.</li> 
                    <li>Transferencias Bancarias: Los pagos también podrán ser realizados a través de transferencias bancarias hacia cuentas específicamente autorizadas por la organización.</li>     
                </ul>
                <table class="table date-table">
                    <thead>
                        <tr>
                            <th>Banco</th>
                            <th>Moneda</th>
                            <th>Titular y Número de Cuenta</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="account in bank_accounts">
                            <td>{{account.bank_entity.name}}</td>
                            <td>soles</td>
                            <td>
                                <ul style=" margin-bottom: 5px; margin-top: -4px; list-style: none;">
                                    <li style="margin-bottom: -5px;">
                                        {{account.account_holder}}
                                    </li>
                                    <li style="margin-bottom: -5px;">
                                       SAC N°{{account.account_number}}
                                    </li>
                                    <li style="margin-bottom: -5px;">
                                        CCI: {{account.cci}}
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <span>QUINTO: ENTREGAS Y FORMA DE ENTREGAS.</span>
                <p>Las entregas que EL LOCADOR otorgará a favor de EL ASESORADO serán cargadas al correo y/o grupo de WhatsApp creado en los siguientes términos: </p>
                <table class="table date-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Avance</th>
                        </tr>
                    </thead>
                    <tbody v-if="contract && contract.projects">
                        <tr v-for="delivery in contract.projects[0].deliveries">
                            <td>{{delivery.date ? dateFormatted(delivery.date) : 'Bajo coordinación con gerencia o tesista'}}</td>
                            <td>{{delivery.advance}}</td>
                        </tr>
                    </tbody>
                </table>
                <template v-if="contract.fifth_article == 1">
                    <p >Además, EL LOCADOR se compromete con entregar a favor de EL ASESORADO los siguientes beneficios adicionales:
                    </p>
                    <ul>
                        <li>Asesoría de preparación metodológica y temática sobre la investigación para la sustentación.</li>
                        <li>Ebook / guía de sustentación escrita.</li>
                        <li>Balotario de preguntas de sustentación.</li>
                        <li>Plantilla de diapositivas en Power Point para la sustentación</li>
                        <li>Reporte de Turnitin.</li>
                    </ul>
                </template>
                <span>SEXTO: EXCLUSIVIDAD</span>
                <p>En virtud de esta cláusula, el contrato suscrito se establece exclusivamente entre EL LOCADOR y EL ASESORADO. Cualquier ampliación relacionada al alcance del servicio que incluya a otras personas requiere una notificación y adenda escrita, junto con la aceptación de los términos y costos adicionales por ambas partes. "El asesorado" asume la responsabilidad total de los pagos adicionales relacionados con cualquier extensión del servicio. "El locador" se reserva el derecho de rechazar dicha ampliación sin consentimiento previo por escrito. Esta cláusula garantiza la transparencia y evita malentendidos en caso de cambios en el alcance de los servicios. Ambas partes aceptan estos términos mediante la firma del contrato.</p>
                
                <span>SÉPTIMO: SOBRE LA RESOLUCIÓN DEL CONTRATO</span>
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
                    diarios por cada día de retraso en la entrega del producto académico correspondiente. Asimismo, si EL ASESORADO
                    no proporciona la información requerida para el desarrollo del trabajo dentro del plazo establecido, las fechas
                    de entrega de los productos académicos se ajustarán proporcionalmente al tiempo de demora en la entrega de dicha
                    información.
                </p>
                <span>NOVENO: CONFIDENCIALIDAD </span>
                <p>EL LOCADOR se compromete a mantener en reserva todos los datos de EL ASESORADO, incluso después de que las demás obligaciones de EL CONTRATO se hayan extinguido; a excepción de aquellos casos que la ley exija lo contrario.</p>
            
                <span>DECIMO: GARANTÍA DEL SERVICIO</span>
                <p v-if="contract.fragment != 1">EL CONTRATO no tiene una cláusula de prescripción de obligaciones por parte de EL LOCADOR  que se rija 
                    por el tiempo, sino que las obligaciones de este se extinguen únicamente cuando EL ASESORADO haya obtenido 
                    el informe aprobatorio de los tres jurados revisores de la tesis; tanto sobre el documento, como en la sustentación.
                </p>
                <p>
                    EL ASESORADO asume la responsabilidad sobre todo tipo de negligencia que pudiera aparecer en el producto 
                    académico, cuando esta es ocasionada por sí mismo, esto es, cuando la información proporcionada por EL 
                    ASESORADO es ilegítima, incorrecta, o influenciada por terceras personas ajenas al vínculo contractual o 
                    personal universitario. 
                </p>
                <span>DÉCIMO PRIMERO: SANCIONES</span>
                <p> En caso de que EL ASESORADO muestre conductas hostiles hacia cualquier miembro de la organización, este 
                    perderá automáticamente todos los beneficios adicionales contenidos en EL CONTRATO. Además, en caso el 
                    servicio no contenga beneficios adicionales, se sancionará a EL ASESORADO con un bono excedente de hasta 
                    S/.50.00 (cincuenta soles).</p>
                <span>DÉCIMO SEGUNDO: SOLUCIÓN DE CONFLICTOS</span>
                <p >En caso de desacuerdo durante la ejecución del presente contrato, estos deberán solucionarlo mediante 
                    conciliación extrajudicial.
                    En caso de presentarse cualquier asunto dudoso o litigioso derivado de la interpretación, aplicación o 
                    ejecución del presente contrato, las partes se someterán al fuero arbitral de la Cámara de Comercio de Lima 
                    según desee el interesado.</p>
                    <span>DÉCIMO TERCERO: BONIFICACIONES</span>
               <p>En caso de que EL ASESORADO refiera a EL LOCADOR y este celebre un contrato de índole similar al presente
                  contrato, EL LOCADOR otorgará a EL ASESORADO una bonificación cuyo monto será evaluado y determinado por el área financiera de EL LOCADOR. Esta bonificación variará hasta un máximo de S/ 1,000.00 y será comunicada expresamente por el personal de ventas al ASESORADO.</p>
                 <p>La evaluación para determinar el monto de la bonificación considerará varios factores, entre ellos el porcentaje de avance de pago del cliente que ya contrató, la dificultad de realización de los trabajos, los tiempos de entrega y el cumplimiento en los pagos, así como otros factores que EL LOCADOR considere pertinentes. EL LOCADOR se reserva el derecho de realizar las verificaciones necesarias para asegurar la autenticidad y la legitimidad de cada contrato referido antes de emitir cualquier bonificación.</p>
                 <p>Este esquema de bonificaciones se aplicará por cada contrato referido que cumpla con los criterios de ingreso especificados anteriormente, y será efectivo una vez que se haya confirmado la celebración del contrato y se haya verificado el cumplimiento de todas las condiciones pertinentes. Ambas partes aceptan estos términos mediante la firma del presente contrato.</p> 
                 <div class="page-break"></div>
                 <p>Las partes declaran haber leído el contrato, por lo que conocen y aceptan todas las cláusulas en su integridad, ambos firman el {{dateTextFormatted
                 (contract.date)}}</p>       
                </div>
                <div class="row mt-5">
                    <div class="col-6">
                        
                            <div class="d-flex flex-column align-items-center">
                                <img src="https://inbestiga.com/inbestiga/public/img/contract/firmaBere.jpg" width="200">
                                <p class="mb-0">__________________________</p>
                                <p class="mb-0">EL LOCADOR</p>
                                <p class="mb-0">Representante Legal</p>
                            </div>
                    </div>
                    <template v-if="contract && contract.quotation">
                        <div class="col-6 pt-5" v-for="customer in contract.quotation.customers">
                        <div class="d-flex flex-column align-items-center pt-5">
                                <p class="mb-0 pt-5">__________________________</p>
                                <p class="mb-0">EL ASESORADO</p>
                                <p class="mb-0">{{ customer.name }}</p>
                            </div>
                    </div>
                    </template>
                   
                </div>
        </main>
        </div>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
    </table>
    <div class="header"> 
        <img
                    src="https://inbestiga.com/inbestiga/public/img/contract/contractHeader.png"
                    class="w-100"
                />
    </div>
    <div class="footer">
        <img
                    src="https://inbestiga.com/inbestiga/public/img/contract/contractFooter.png"
                    class="w-100"
                />
    </div>
</template>

<script>
import moment from 'moment';
import { localeData } from "moment_spanish_locale";

export default {
    name: "PrintableDocument",
    created() {
        moment.locale("es", localeData);
    },
    data() {
        return {
            contract: {},
            bank_accounts: []
        };
    },
    methods: {
        dateFormatted(date){
            return moment(date).format('DD/MM/YYYY')
        },
        dateTextFormatted(date){
            return moment(date).format('DD [de] MMMM [de] YYYY')
        },
        upperCaseText(text){
            return text.toUpperCase();
        },
        getContract() {
            axios
                .get("/api/contract-file/" + this.$route.params.contractId)
                .then((result) => {
                    this.contract = result.data.contract;
                    this.bank_accounts = result.data.bank_accounts;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getContract();
    },
};
</script>

<style scoped>

.content{
    padding: 0px 0px 0px 40px;
    font-size: 12px;
}

h1{
    text-align: center;
    font-size: 16px;
    font-weight: bold;
}

.date-table td,th{
    text-align: center;
    padding: 0px 2px;
}

.header, .header-space{
  height: 170px;
}
.footer, .footer-space {
    height: 120px;
}

.header {
  position: fixed;
  top: 0;
}
.footer {
  position: fixed;
  bottom: 0;
}

.page-break {
                page-break-after: always;
            }
            span{
                font-weight: 700;
            }
</style>
