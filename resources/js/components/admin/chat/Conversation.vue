<template>
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
                <i class="bx bx-phone-call cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                <i class="bx bx-video cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                <i class="bx bx-search cursor-pointer d-sm-block d-none me-3 fs-4"></i>
                </div>
            </div>
            </div>
            <div ref="bodyChats" id="bodyChats" class="chat-history-body bg-body ps" style="height:80vh; overflow-y: scroll !important;">
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
            <SendMessage/>
        </div>
    </div>
</template>
<script>
import SendMessage from './SendMessage.vue'
import {useCounterStore} from '../../../stores/UserStore'

export default{
    components:{SendMessage},
    setup(){
      const store = useCounterStore()
      return{
        store
      }
    },
    data(){
        return{
            user_selected: {},
            selected_messages: []
        }
    },
    methods:{
        sendMessage(){
            
        }
    }
}

</script>