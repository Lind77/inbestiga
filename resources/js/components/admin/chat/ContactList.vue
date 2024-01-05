<template>
    <div class="chat-history-body">
        <ul class="list-unstyled chat-history mb-0 px-3 py-2">
            <!--  <h5 class="text-primary mb-2">Chats 123</h5> -->
            <li class="chat-contact-list-item chat-contact-list-item-title">
                <h5 class="text-primary mb-0">Chats</h5>
            </li>
            <li class="contact rounded py-2 mb-2" :id="`user${message.emisor.id}`" v-for="(message, index) in messages"
                :key="index" @click="selectContact(message.emisor, index)">
                <div class="d-flex justify-content-start overflow-hidden">
                    <div class="flex-shrink-0 avatar ms-2">
                        <div class="flex-shrink-0 me-3" v-if="message.emisor.images[0]">
                            <div class="avatar avatar-online">
                                <img :src="'/../public/files/' + message.emisor.images[0].url"
                                    class="w-px-40 h-px-40 rounded-circle" style="object-fit:cover;" />
                            </div>
                        </div>
                        <span v-else class="avatar-initial rounded-circle bg-primary">{{ store.authUser.name[0] }}</span>
                    </div>
                    <div class="d-flex flex-column align-items-start w-100 ps-2">
                        <h6 :id="`name${message.emisor.id}`" class="contact-name mb-0">{{ message.emisor.name }}</h6>
                        <p class="text-message m-0 h6 text-secondary" :id="`message${message.emisor.id}`">{{
                            message.message.length > 20 ?
                            message.message.substr(0, 19) +
                            '...' : message.message }}</p>
                    </div>
                </div>
            </li>
            <li class="chat-contact-list-item chat-contact-list-item-title">
                <h5 class="text-primary mb-0">Contactos</h5>
            </li>
            <li class="contact rounded py-2 mb-2" :id="`user${contact.id}`" v-for="(contact, index) in contacts"
                :key="index" @click="selectContact(contact, index)">
                <div class="d-flex justify-content-start overflow-hidden">
                    <div class="flex-shrink-0 avatar ms-2">
                        <div class="flex-shrink-0 me-3" v-if="contact.images && contact.images[0]">
                            <div class="avatar avatar-online">
                                <img :src="'/../public/files/' + contact.images[0].url"
                                    class="w-px-40 h-px-40 rounded-circle" style="object-fit:cover;" />
                            </div>
                        </div>
                        <span v-else class="avatar-initial rounded-circle bg-primary">{{ store.authUser.name[0] }}</span>
                    </div>
                    <div class="d-flex flex-column align-items-start w-100 ps-2">
                        <h6 :id="`name${contact.id}`" class="contact-name mb-0">{{ contact.name }}</h6>
                        <p :id="`message${contact.id}`" class="text-message m-0 h6 text-secondary">
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
import { userStore } from '../../../stores/UserStore'

export default {
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    props: {
        users: Array,
        messages: Array,
        contacts: Array
    },
    methods: {
        selectContact(user, index) {
            console.log(user, index)
            if (window.innerWidth < 567) {
                this.$emit('hideList')
            }
            document.querySelectorAll('.contact').forEach((contact) => {
                contact.classList.remove('bg-primary')
            })
            document.querySelectorAll('.contact-name').forEach((contact) => {
                contact.classList.remove('text-white')
            })
            document.querySelectorAll('.text-message').forEach((contact) => {
                contact.classList.remove('text-white')
            })
            if (document.getElementById('user' + user.id)) {
                document.getElementById('user' + user.id).classList.add('bg-primary')
                document.getElementById('name' + user.id).classList.add('text-white')
                document.getElementById('message' + user.id).classList.add('text-white')
            }

            this.$emit('listConversations', user)
        }
    }
}

</script>
<style scoped>
.chat-history-body {
    overflow-y: scroll;
    height: 68vh;
}

.list-unstyled {
    height: 10%;
}
</style>