<template>
    <div id="bodyChats" class="chat-history-body bg-body ps" style="height:52vh; overflow-y: scroll !important;">
        <ul class="list-unstyled chat-history mb-0 px-2 py-2">
            <li class="chat-message" v-for="message in selected_messages">
                <div class="d-flex justify-content-end overflow-hidden" v-if="message.emisor_id == store.authUser.id">
                    <div class="chat-message-wrapper">
                        <div class="chat-message-text chat-message-right">
                            <p class="mb-0">{{ message.message }}</p>
                        </div>
                        <div class="text-end text-muted mt-1">
                            <!-- <i class="bx bx-check-double text-success"></i> -->
                            <small>{{ formattedTime(message.created_at) }}</small>
                        </div>
                    </div>
                    <div class="flex-shrink-0 avatar ms-2">
                        <span class="avatar-initial rounded-circle bg-primary">{{ store.authUser.name[0] }}</span>
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
                            <small>{{ formattedTime(message.created_at) }}</small>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: -751px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 751px; height: 324px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 226px; height: 97px;"></div>
        </div>
    </div>
</template>
<script>
import SendMessage from './SendMessage.vue'
import { userStore } from '../../../stores/UserStore'
import moment from 'moment'

export default {
    props: {
        selected_messages: Array,
        user_selected: Object
    },
    components: { SendMessage },
    setup() {
        const store = userStore()
        return {
            store
        }
    },
    methods: {
        formattedTime(date) {
            return moment(date).format('h:mm a')
        }
    }
}

</script>
<style scoped>
.list-unstyled {
    padding-left: 0;
    list-style: none;
}

.chat-message-right {
    background-color: #696cff;
    color: #fff;
    border-radius: 5px;
    padding: 10px;
    margin: 5px 0px 5px 0px;
}

.chat-message-left {
    background-color: #fff;
    color: #607387;
    border-radius: 5px;
    padding: 10px;
    margin: 5px 0px 5px 0px;
    box-shadow: 0 0.125rem 0.25rem rgb(161 172 184 / 40%);
}
</style>