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

        <h1>Schedules</h1>

        <input type="range" list="tickmarks" step="20" />

        <datalist id="tickmarks">
            <option value="0"></option>
            <option value="20"></option>
            <option value="40"></option>
            <option value="60"></option>
            <option value="80"></option>
            <option value="100"></option>
        </datalist>

        <table class="table">
            <thead>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miercoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sabado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            :step="5"
                            :min="750"
                            :max="1350"
                            :format="formatTime"
                        />
                    </td>
                    <!--  <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            step="10"
                        />
                    </td>
                    <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            step="10"
                        />
                    </td>
                    <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            step="10"
                        />
                    </td>
                    <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            step="10"
                        />
                    </td>
                    <td>
                        <Slider
                            orientation="vertical"
                            v-model="value"
                            step="10"
                        />
                    </td> -->
                </tr>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import Slider from "@vueform/slider";
import moment from "moment";

export default {
    components: {
        Slider,
    },
    data() {
        return {
            content: "",
            email: "",
            showField: false,
            name: "Julio",
            customersLobo: [],
            value: [20, 40],
            formatTime(value) {
                return moment.utc(value * 3600 * 10).format("HH:mm a");
            },
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
<style src="@vueform/slider/themes/default.css"></style>
