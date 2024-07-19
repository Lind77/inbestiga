<template>
    <div class="container">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label"
                >Email address</label
            >
            <input
                type="email"
                class="form-control"
                v-model="email"
                id="exampleFormControlInput1"
                placeholder="name@example.com"
            />
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label"
                >Example textarea</label
            >
            <textarea
                class="form-control"
                id="exampleFormControlTextarea1"
                rows="3"
                v-model="content"
            ></textarea>
        </div>
        <button class="btn btn-success" @click="sendMail">Enviar Email</button>

        <p>EditTextClick</p>
        <p v-show="!showField" @click="showInput">{{ name }}</p>
        <input
            v-show="showField"
            type="text"
            v-model="name"
            ref="name"
            class="form-control"
            @blur="hideInput"
        />

        <h4>Kanban</h4>

        <button
            id="tooltip"
            @mouseover="tooltip"
            type="button"
            class="btn btn-primary"
            data-bs-toggle="tooltip"
            data-bs-offset="0,4"
            data-bs-placement="right"
            data-bs-html="true"
            data-bs-original-title="<i class='bx bx-trending-up bx-xs' ></i> <span>Tooltip on right</span>"
        >
            Right
        </button>

        <button
            id="popover"
            @click="popover"
            type="button"
            class="btn btn-primary text-nowrap"
            data-bs-toggle="popover"
            data-bs-offset="0,14"
            data-bs-placement="right"
            data-bs-html="true"
            data-bs-content="<p>This is a very beautiful popover, show some love.</p> <div class='d-flex justify-content-between'><button type='button' class='btn btn-sm btn-outline-secondary'>Skip</button><button type='button' class='btn btn-sm btn-primary'>Read More</button></div>"
            data-bs-original-title="Popover Title"
        >
            Popover on right
        </button>
    </div>
</template>
<script>
export default {
    data() {
        return {
            content: "",
            email: "",
            showField: false,
            name: "Julio",
            customersLobo: [],
        };
    },
    methods: {
        getCustomersQuotation() {
            axios
                .get("/api/customers-lobo")
                .then((result) => {})
                .catch((err) => {});
        },
        tooltip() {
            $("#tooltip").tooltip("show");
        },
        popover() {
            $("#popover").popover("show");
        },
        hideInput() {
            this.showField = false;
        },
        showInput() {
            this.showField = true;
            this.$nextTick(() => {
                this.$refs.name.select();
            });
        },
        sendMail() {
            const fd = new FormData();
            fd.append("email", this.email);
            fd.append("content", this.content);

            axios
                .post("/api/send-welcome-email", fd)
                .then((result) => {
                    this.$swal("Mensaje enviado correctamente");
                })
                .catch((err) => {
                    console.log(err);
                });
        },
    },
    mounted() {
        this.getCustomersQuotation();
    },
};
</script>
<style></style>
