<template>
    <div class="chat-history-body">
        <ul class="list-unstyled chat-history mb-0 px-3 py-2">
            <!--  <h5 class="text-primary mb-2">Chats 123</h5> -->
            <li class="chat-contact-list-item chat-contact-list-item-title">
                <h5 class="text-primary mb-0 fw-bold">Chats</h5>
            </li>
            <template v-for="(message, index) in messages">
                <Contact :message="message" @selectContact="selectContact" />
            </template>
            <!--  <li
                class="contact rounded py-2 mb-2"
                :id="`user${message.emisor.id}`"
                v-for="(message, index) in messages"
                :key="index"
                @click="selectContact(message.emisor, index)"
            >
                <div class="d-flex justify-content-start">
                    <div class="flex-shrink-0 avatar ms-2">
                        <div
                            class="flex-shrink-0 me-3"
                            v-if="message.emisor.images[0]"
                        >
                            <div class="avatar">
                                <img
                                    :src="
                                        'https://inbestiga.com/inbestiga/public/files/' +
                                        message.emisor.images[0].url
                                    "
                                    class="w-px-50 h-px-50 rounded-circle"
                                    style="object-fit: cover"
                                />
                            </div>
                        </div>
                        <span
                            v-else
                            class="avatar-initial rounded-circle bg-primary"
                            >{{ message.emisor.name[0] }}</span
                        >
                    </div>
                    <div
                        class="d-flex flex-column align-items-start w-100 ps-5 h-auto"
                    >
                        <h6
                            :id="`name${message.emisor.id}`"
                            class="contact-name mb-0 fw-bold"
                        >
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
            </li> -->
            <li class="chat-contact-list-item chat-contact-list-item-title">
                <h5 class="text-primary mb-0">Contactos</h5>
            </li>
            <li
                class="contact rounded py-2 mb-2"
                :id="`user${contact.id}`"
                v-for="(contact, index) in contacts"
                :key="index"
                @click="selectContact(contact, index)"
            >
                <div class="d-flex justify-content-start overflow-hidden">
                    <div class="flex-shrink-0 avatar ms-2">
                        <div
                            class="flex-shrink-0 me-3"
                            v-if="contact.images && contact.images[0]"
                        >
                            <div class="avatar">
                                <img
                                    :src="
                                        '/../inbestiga/public/files/' +
                                        contact.images[0].url
                                    "
                                    class="w-px-40 h-px-40 rounded-circle"
                                    style="object-fit: cover"
                                />
                            </div>
                        </div>
                        <span
                            v-else
                            class="avatar-initial rounded-circle bg-primary"
                            >{{ contact.name[0] }}</span
                        >
                    </div>
                    <div
                        class="d-flex flex-column align-items-start w-100 ps-2"
                    >
                        <h6 :id="`name${contact.id}`" class="contact-name mb-0">
                            {{ contact.name }}
                        </h6>
                        <p
                            :id="`message${contact.id}`"
                            class="text-message m-0 h6 text-secondary"
                        >
                            {{ contact.roles[0].name }}
                        </p>
                        <!-- <p class="text-message m-0 h6 text-secondary" :id="`message${message.emisor.id}`">{{
                            message.message.length > 20 ?
                            message.message.substr(0, 19) +
                            '...' : message.message }}</p> -->
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
import { userStore } from "../../../stores/UserStore";
import Contact from "./Contact.vue";

export default {
    components: { Contact },
    setup() {
        const store = userStore();
        return {
            store,
        };
    },
    props: {
        users: Array,
        messages: Array,
        contacts: Array,
    },
    methods: {
        selectContact(user) {
            document.querySelectorAll(".contact").forEach((contact) => {
                contact.classList.remove("selected");
            });

            document.querySelectorAll(".contact-name").forEach((contact) => {
                contact.classList.remove("text-white");
            });
            document.querySelectorAll(".text-message").forEach((contact) => {
                contact.classList.remove("text-white");
            });

            /* if (window.innerWidth < 567) {
                this.$emit("hideList");
            }


            });
            if (document.getElementById("user" + user.id)) {
                document
                    .getElementById("user" + user.id)
                    .classList.add("bg-primary");

            }

             */
            this.$emit("listConversations", user);
        },
    },
};
</script>
<style scoped>
.chat-history-body {
    overflow-y: scroll;
    height: 68vh;
}

.list-unstyled {
    height: 10%;
}

.selected {
    background-color: #696cff;
    color: #fff;
    transition: 0.9s;
}
</style>
