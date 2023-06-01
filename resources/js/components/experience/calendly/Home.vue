<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Calendly</h4>
        <div class="calendly-inline-widget" data-url="https://calendly.com/riuyagami" style="min-width:320px;height:700px;">
        </div>
    </div>
</template>
<script>
export default {
    methods: {
        login() {
            // Make an Axios request to the Calendly API.
            axios.post("https://api.calendly.com/v1/events/book", {
                eventId: "YOUR_EVENT_ID",
                email: "riuyagami@gmail.com",
                name: "riuyagami",
            }).then((response) => {
                // Do something with the response.
            }).catch((error) => {
                // Handle the error.
            });
        }
    }
}
</script>
<style></style>