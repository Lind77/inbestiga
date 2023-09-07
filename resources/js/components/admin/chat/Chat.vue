<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold">Chat</h4>
        <div class="card chat-card">
            <div class="row">
                <div class="d-none d-lg-block col-xs-12 col-lg-4 pe-0" id="listSection">
                    <div class="chat-history-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center p-3">
                            <div class="d-flex overflow-hidden align-items-center">
                                <i @click="hideList" class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2"
                                    data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                                <div class="flex-shrink-0 avatar me-2">
                                    <span class="avatar-initial rounded-circle bg-primary" v-if="store.user">{{
                                        store.user.name[0] }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <ContactList :users="users" @listConversations="listConversations" @hideList="hideList" />
                </div>
                <div class="col-xs-8 col-sm-12 col-lg-8 app-chat-history ps-0" id="chatConverstion">
                    <div class="chat-history-wrapper">
                        <div class="chat-history-header border-bottom">
                            <div class="d-flex justify-content-between align-items-center p-3">
                                <div class="d-flex overflow-hidden align-items-center">
                                    <i @click="showList" class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2"
                                        data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                                    <div class="flex-shrink-0 avatar">
                                        <span class="avatar-initial rounded-circle bg-primary" v-if="user_selected.name">{{
                                            user_selected.name[0] }}</span>
                                    </div>
                                    <div class="chat-contact-info flex-grow-1 ms-3">
                                        <h6 class="m-0" v-if="user_selected.name">{{ user_selected.name }}</h6>
                                        <small class="user-status text-muted" v-if="user_selected.roles">{{
                                            user_selected.roles[0].name }}</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                </div>
                            </div>
                        </div>

                        <Conversation :selected_messages="selected_messages" :user_selected="user_selected" />

                        <SendMessage @message="setNewMessage" :user_selected="user_selected" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import SendMessage from './SendMessage.vue'
import ContactList from './ContactList.vue'
import Conversation from './Conversation.vue'

import { userStore } from '../../../stores/UserStore'

export default {
    components: { ContactList, Conversation, SendMessage },
    data() {
        return {
            users: [],
            user_selected: {},
            selected_messages: [],
            hidden: true,
        }
    },
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    methods: {
        showList() {
            document.getElementById('listSection').classList.remove('d-none')
            document.getElementById('chatConverstion').classList.add('d-none')
        },
        hideList() {
            document.getElementById('listSection').classList.add('d-none')
            document.getElementById('chatConverstion').classList.remove('d-none')
        },
        getAllUsers() {
            axios.get('/api/users')
                .then(res => {
                    this.users = res.data.filter(user => user.id != this.store.authUser.id)
                })
                .catch(err => {
                    console.log(err)
                })
        },
        setNewMessage(msg) {
            this.selected_messages.push(msg)
            this.scrollToBottom()
        },
        listConversations(contact) {
            this.user_selected = contact
            var token = localStorage.getItem('token')
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            axios.get('/api/getAllMessagesById/' + contact.id)
                .then(res => {
                    this.selected_messages = res.data
                    console.log(this.selected_messages)
                    this.scrollToBottom()
                })
                .catch(err => {
                    console.log(err)
                })
        },
        scrollToBottom() {
            setTimeout(() => {
                if (document.getElementById('bodyChats')) {
                    document.getElementById('bodyChats').scrollTop = document.getElementById('bodyChats').scrollHeight
                }
            }, 100);
        },
        setNewMessageBroadcasted(message) {
            if (this.user_selected && this.user_selected.id == message.emisor_id) {
                this.setNewMessage(message)
            }
        }
    },
    mounted() {
        console.log(this.store.authUser.id)
        Echo.private(`message.${this.$route.params.userId}`)
            .listen('NewMessage', (e) => {
                this.setNewMessageBroadcasted(e.message)
                Notification.requestPermission()
                    .then((result) => {
                        if (result === 'granted') {
                            new Notification('Tienes un nuevo mensaje')
                        }
                    }).catch((err) => {

                    });
            })
        this.getAllUsers()
    }
}
</script>
<style scoped>
.chat-card {
    height: 70vh;
}

.hidden {
    display: block;
}

/* width */
::-webkit-scrollbar {
    width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
    background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: rgba(67, 89, 113, 0.075);
    border-radius: 5px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: rgba(67, 89, 113, .7);
}
</style>