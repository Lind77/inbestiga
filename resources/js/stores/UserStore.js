import { defineStore } from "pinia"
import axios from 'axios'

export let userStore = defineStore('counter', {
    state(){
        return {
            authUser: null
        }
    },
    getters: {
        user: (state) => state.authUser
    },
    actions:{
      setUser(user){
        this.authUser = user
      }
    },
    persist: true
    
})

