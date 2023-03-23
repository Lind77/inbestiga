<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3">Chat</h4>
        <div class="card vh-100">
           <div class="row">
            <div class="col-4">
                <div class="chat-history-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex overflow-hidden align-items-center">
                        <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                        <div class="flex-shrink-0 avatar me-2">
                            <span class="avatar-initial rounded-circle bg-primary" v-if="store.authUser">{{ store.authUser.name[0] }}</span>
                        </div>
                        <div class="input-group input-group-merge rounded-pill ms-1">
                            <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search fs-4"></i></span>
                            <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                        </div>
                        </div>

                    </div>
                </div>
                <ContactList :users="users" @listConversations="listConversations"/>
            </div>
            <div class="col-8 app-chat-history">
        <div class="chat-history-wrapper">
            <div class="chat-history-header border-bottom">
            <div class="d-flex justify-content-between align-items-center p-3">
                <div class="d-flex overflow-hidden align-items-center">
                <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                <div class="flex-shrink-0 avatar">
                    <span class="avatar-initial rounded-circle bg-primary" v-if="user_selected.name">{{ user_selected.name[0] }}</span>
                </div>
                <div class="chat-contact-info flex-grow-1 ms-3">
                    <h6 class="m-0" v-if="user_selected.name">{{ user_selected.name }}</h6>
                    <small class="user-status text-muted" v-if="user_selected.roles">{{ user_selected.roles[0].name }}</small>
                </div>
                </div>
                <div class="d-flex align-items-center">
                <!-- <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i> -->
                </div>
            </div>
            </div>
            
            <Conversation :selected_messages="selected_messages" :user_selected="user_selected"/>
            
            <!-- Chat message form -->
            <SendMessage @message="setNewMessage" :user_selected="user_selected"/>
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

import {userStore} from '../../../stores/UserStore'

export default {
    components: { ContactList, Conversation, SendMessage },
    data(){
        return{
            users:[],
            user_selected: {},
            selected_messages:[],
        }
    },  
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    methods:{
        getAllUsers(){
            axios.get('/api/getAllUsers')
            .then(res => {
                this.users= res.data.filter(user => user.id != this.store.authUser.id)
            })
            .catch(err =>{
                console.log(err)
            })
        },
        setNewMessage(msg){
            this.selected_messages.push(msg)
            this.scrollToBottom()
        },
        listConversations(contact){
            this.user_selected = contact
            var token = localStorage.getItem('token')
            window.axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
            axios.get('/api/getAllMessagesById/'+ contact.id)
            .then(res => {
                this.selected_messages= res.data
                console.log(this.selected_messages)
                this.scrollToBottom()
            })
            .catch(err =>{
                console.log(err)
            })
        },
        scrollToBottom(){
            setTimeout(() => {
                if(document.getElementById('bodyChats')){
                document.getElementById('bodyChats').scrollTop = document.getElementById('bodyChats').scrollHeight
            }
            }, 100);
        },
        setNewMessageBroadcasted(message){
            if(this.user_selected && this.user_selected.id == message.emisor_id){
                this.setNewMessage(message)
            }
        }
    },
    mounted(){
        console.log(this.store.authUser.id)
        Echo.private(`message.${this.$route.params.userId}`)
        .listen('NewMessage',(e)=>{
            this.setNewMessageBroadcasted(e.message)
        })
        this.getAllUsers()
    }
}
</script>
