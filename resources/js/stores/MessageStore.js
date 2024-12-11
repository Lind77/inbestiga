import { defineStore } from "pinia"

export let useMessageStore  = defineStore('messages',{
    state(){
        return {
            messages: []
        }
    },
    actions: {
        addMessage(newMessage) {
            console.log(newMessage);
            var messageSelected = this.messages.find(message => message.message.emisor_id == newMessage.message.emisor_id)
            if (messageSelected){   
                messageSelected.message.message = newMessage.message.message
            }else{
                this.messages.unshift(newMessage);
            }
        },
        removeMessage(index) {
            this.messages.splice(index, 1);
        },
        cleanMessages(){
            this.messages = [];
        }
    },
    persist: true
})