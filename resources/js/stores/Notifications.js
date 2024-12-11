import { defineStore } from "pinia"

export let useNotificationStore  = defineStore('notifications',{
    state(){
        return {
            notifications: []
        }
    },
    actions: {
        addNotification(notification) {
            this.notifications.push(notification);
        },
        removeNotification(index) {
            this.notifications.splice(index, 1);
        }
    },
    persist: true
})