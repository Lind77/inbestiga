<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Realtime</h4>
        <div class="card vh-100">
           <div class="row">
            <div class="col-4">
                <div class="chat-history-header border-bottom">
                    <div class="d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex overflow-hidden align-items-center">
                        <i class="bx bx-menu bx-sm cursor-pointer d-lg-none d-block me-2" data-bs-toggle="sidebar" data-overlay="" data-target="#app-chat-contacts"></i>
                        <div class="flex-shrink-0 avatar me-2">
                            <span class="avatar-initial rounded-circle bg-primary">J</span>
                        </div>
                        <div class="input-group input-group-merge rounded-pill ms-1">
                            <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search fs-4"></i></span>
                            <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31">
                        </div>
                        </div>

                    </div>
                </div>
                <div class="chat-history-body ps ps--active-y ">
                    <ul class="list-unstyled chat-history mb-0 px-3 py-2 ">
                        <h5 class="text-primary mb-2">Chats</h5>
                        <li class="contact rounded py-2 mb-2" :id="`user${user.id}`" v-for="user in users" @click="selectContact(user)">
                        <div class="d-flex justify-content-start overflow-hidden">
                            <div class="flex-shrink-0 avatar ms-2">
                            <span class="avatar-initial rounded-circle bg-success">{{ user.name[0] }}</span>
                            </div>
                            <h5 :id="`name${user.id}`" class="contact-name ps-2">{{ user.name }}</h5> 
                        </div>
                            
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-8 app-chat-history">
                <div class="chat-history-wrapper" v-if="user_selected.name">
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
                        <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                        <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                        <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                        </div>
                    </div>
                    </div>
                    <div id="bodyChats" class="chat-history-body bg-body ps" style="height:80vh; overflow-y: scroll !important;">
                    <ul class="list-unstyled chat-history mb-0 px-2 py-2">
                        <li class="chat-message" v-for="message in selected_messages">
                        <div class="d-flex justify-content-end overflow-hidden" v-if="message.emisor_id == store.authUser[0].id">
                            <div class="chat-message-wrapper">
                            <div class="chat-message-text chat-message-right">
                                <p class="mb-0">{{ message.message }}</p>
                            </div>
                            <div class="text-end text-muted mt-1">
                                <i class="bx bx-check-double text-success"></i>
                                <small>10:00 AM</small>
                            </div>
                            </div>
                            <div class="flex-shrink-0 avatar ms-2">
                                <span class="avatar-initial rounded-circle bg-primary">{{ store.authUser[0].name[0] }}</span>
                            </div>
                        </div>
                        <div v-else class="d-flex justify-content-start overflow-hidden">
                            <div class="flex-shrink-0 avatar me-2">
                                <span class="avatar-initial rounded-circle bg-primary">{{ user_selected.name[0] }}</span>
                            </div>
                            <div class="chat-message-wrapper">
                            <div class="chat-message-text chat-message-left">
                                <p class="mb-0">{{ message.message }}</p>
                            </div>
                            <div class="text-muted">
                                <small>10:02 AM</small>
                            </div>
                            </div>
                        </div>
                        </li>
                    </ul>
                    <div class="ps__rail-x" style="left: 0px; bottom: -751px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 751px; height: 324px; right: 0px;"><div class="ps__thumb-y" tabindex="0" style="top: 226px; height: 97px;"></div></div></div>
                    <!-- Chat message form -->
                    <div class="chat-history-footer shadow p-2">
                    <div class="form-send-message d-flex justify-content-between align-items-center ">
                        <input class="form-control message-input border-0 me-3 shadow-none" v-model="actual_message" placeholder="Escribe tu mensaje...">
                        <div class="message-actions d-flex align-items-center">
                        <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
                        <label for="attach-doc" class="form-label mb-0">
                            <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
                            <input type="file" id="attach-doc" hidden="">
                        </label>
                        <button class="btn btn-primary d-flex">
                            <i class="bx bx-paper-plane me-md-1 me-0"></i>
                            <span @click="sendMessage" class="align-middle d-md-inline-block d-none">Enviar</span>
                        </button>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
           </div>
        </div>
    </div>    
</template>
<script>
import axios from 'axios';
import {useCounterStore} from '../../stores/UserStore'

export default {
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
        return{
            messages:[],
            users:[],
            actual_message:'',
            user_selected: {},
            selected_messages:[]
        }
    },
    methods:{
        selectContact(user){

            document.querySelectorAll('.contact').forEach((contact)=>{
                contact.classList.remove('bg-primary')
            })

            document.querySelectorAll('.contact-name').forEach((contact)=>{
                contact.classList.remove('text-white')
            })
            if(document.getElementById('user'+user.id)){
                document.getElementById('user'+user.id).classList.add('bg-primary')
            document.getElementById('name'+user.id).classList.add('text-white')
            }
            

            this.user_selected = user

            this.selected_messages = this.messages.filter(message => message.receptor_id == user.id && message.emisor_id == this.store.authUser[0].id || message.receptor_id == this.store.authUser[0].id && message.emisor_id == user.id)

            let bodyChat = document.getElementById('bodyChats')
            console.log(bodyChat)
            //bodyChat.scrollTop = bodyChat.scrollHeight

        },
        sendMessage(){
            console.log('enviando mensaje')

            const fd = new FormData()

            fd.append('emisor_id', this.store.authUser[0].id )
            fd.append('receptor_id', this.user_selected.id)
            fd.append('message', this.actual_message)
            fd.append('viewed', 0)

            axios.post('/api/storeMessage', fd)
            .then(res => {
                console.log(res)
                this.getAllMessages()
                this.actual_message = ''
            })
            .catch(err =>{
                console.log(err)
            })
        },
        getAllMessages(){
            axios.get('/api/getAllMessages')
            .then(res => {
                console.log(res)
                this.messages = res.data
            })
            .catch(err =>{
                console.log(err)
            })
        },
        getAllUsers(){
            axios.get('/api/getAllUsers')
            .then(res => {
                console.log(res)
                this.users= res.data.filter(user => user.id != this.store.authUser[0].id)
            })
            .catch(err =>{
                console.log(err)
            })
        }
    },
    mounted(){
        this.getAllMessages()
        this.getAllUsers()
    },
    watch:{
        messages(){
            console.log('los mensajes se han actualizado')
            if(this.user_selected != {}){
                this.selectContact(this.user_selected)
            }    
           
        }
    }
}
</script>
<style scoped>
    .list-unstyled {
        padding-left: 0;
        list-style: none;
    }
    .chat-message-right{
        background-color: #696cff;
        color: #fff;
        border-radius: 5px;
        padding: 10px;
        margin: 5px 0px 5px 0px;
    }
    .chat-message-left{
        background-color: #fff;
        color: #607387;
        border-radius: 5px;
        padding: 10px;
        margin: 5px 0px 5px 0px;
        box-shadow: 0 0.125rem 0.25rem rgb(161 172 184 / 40%);
    }
</style>