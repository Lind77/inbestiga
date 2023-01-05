import { defineStore } from "pinia"
import axios from 'axios'

export let useCounterStore = defineStore('counter', {
    state(){
        return {
            authUser: null,
            token: localStorage.getItem("token")
        }
    },
    getters: {
        user: (state) => state.authUser
    },
    actions:{
    async getUser(){
    var token = localStorage.getItem("token")  
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${ token }`
    await axios.get('/api/user')
      .then((res) => {
        this.authUser = res.data
        console.log(this.authUser)
      })
      .catch((err) => {
        console.log(err)
      })
    }
    }
})