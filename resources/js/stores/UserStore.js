import { defineStore } from "pinia"
import axios from 'axios'

export let useCounterStore = defineStore('counter', {
    state(){
        return {
            authUser: null,
            rol: '',
            token: localStorage.getItem("token"),
            memoir:[],
            userId:0
        }
    },
    getters: {
        user: (state) => state.authUser
    },
    actions:{
    async getUser(){
    var token = localStorage.getItem("token")  
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${ token }`
    await axios.get('./api/user')
      .then((res) => {
        this.authUser = res.data
        this.userId = this.authUser[0].id
        this.rol = this.authUser[0].roles[0].name
        this.memoir = this.authUser[0].memoir
      })
      .catch((err) => {
        console.log(err)
      })
    }
    }
})