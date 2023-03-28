<template>
    <div class="chat-history-body ps ps--active-y ">
        <ul class="list-unstyled chat-history mb-0 px-3 py-2 ">
            <h5 class="text-primary mb-2">Chats</h5>
            <li class="contact rounded py-2 mb-2" :id="`user${user.id}`" v-for="(user, index) in users" :key="index" @click="selectContact(user, index)">
            <div class="d-flex justify-content-start overflow-hidden">
                <div class="flex-shrink-0 avatar ms-2">
                <span class="avatar-initial rounded-circle bg-success">{{ user.name[0] }}</span>
                </div>
                <h5 :id="`name${user.id}`" class="contact-name ps-2">{{ user.name }}</h5> 
            </div>
                
            </li>
        </ul>
    </div>
</template>
<script>
import {userStore} from '../../../stores/UserStore'

export default{
    setup(){
      const store = userStore()
      return{
        store
      }
    },
    props:{
        users: Array
    },
    methods:{
        selectContact(user, index){

            console.log(window.innerWidth)
            if(window.innerWidth < 567){
                this.$emit('hideList')
            }

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
            
            this.$emit('listConversations', user)
        }
    }
}

</script>