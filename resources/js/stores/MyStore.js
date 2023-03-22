import { defineStore } from 'pinia'

export const useMyStore = defineStore({
    id:'myStore',
    state: () => ({
        count: 0,
        name: 'Lind'
    }),
    actions:{
        increment(){
            this.count++
        }
    }
})