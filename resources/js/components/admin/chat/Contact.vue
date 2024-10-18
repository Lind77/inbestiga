<template>
    <li
        class="contact rounded py-2 mb-2 cursor-pointer"
        :id="`user${message.emisor.id}`"
        @click="selectContact(message.emisor)"
    >
        <div class="d-flex">
            <template v-if="message.emisor.images[0]">
                <img
                    :src="
                        'https://inbestiga.com/inbestiga/public/files/' +
                        message.emisor.images[0].url
                    "
                    class="rounded-circle ms-2"
                    style="object-fit: cover"
                />
            </template>
            <template v-else>
                <span class="avatar-initial rounded-circle bg-primary">{{
                    message.emisor.name[0]
                }}</span>
            </template>
            <div class="ms-3 text-contact">
                <h6 :id="`name${message.emisor.id}`" class="contact-name mb-0">
                    {{ message.emisor.name }}
                </h6>
                <p
                    class="text-message m-0 h6 text-secondary"
                    :id="`message${message.emisor.id}`"
                >
                    {{
                        message.message.length > 20
                            ? message.message.substr(0, 19) + "..."
                            : message.message
                    }}
                </p>
            </div>
        </div>
        <!--  -->
    </li>
</template>
<script>
export default {
    props: {
        message: Object,
    },
    methods: {
        selectContact(emisor) {
            this.$emit("selectContact", emisor);
            $(`#user${emisor.id}`).addClass("selected");
            document
                .getElementById("name" + emisor.id)
                .classList.add("text-white");
            document
                .getElementById("message" + emisor.id)
                .classList.add("text-white");
        },
    },
};
</script>
<style scoped>
.contact {
    border: 1px #7474745d solid;
}

.rounded-circle {
    width: 60px;
    height: 60px;
}

.contact-name {
    color: #696cff;
}
</style>
