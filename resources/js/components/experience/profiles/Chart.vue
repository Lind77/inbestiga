<template>
    <div>
        <apexchart
            width="490"
            type="donut"
            :options="options"
            :series="series"
        ></apexchart>
    </div>
</template>
<script>
export default {
    data() {
        return {
            options: {
                labels: [
                    "Tema",
                    "Plan de Tesis",
                    "Observaciones del Plan de Tesis",
                    "Aprobación del Plan de Tesis",
                    "Aplicación de instrumento",
                    "Elaboración de Informe Final",
                    "Observaciones del informe final",
                    "Revisión de jurados",
                    "Sustentación Final",
                ],
                dataLabels: {
                    enabled: false, // Establece esta propiedad en "false" para ocultar los porcentajes
                },
            },
            series: [
                11.11, 11.11, 11.11, 11.11, 11.11, 11.11, 11.11, 11.11, 11.11,
            ],
        };
    },
};
</script>
