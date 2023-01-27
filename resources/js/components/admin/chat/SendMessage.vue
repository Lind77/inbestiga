<template>
    <div class="chat-history-footer shadow p-2">
    <div class="form-send-message d-flex justify-content-between align-items-center ">
        <input class="form-control message-input border-0 me-3 shadow-none" @keydown.enter="sendMessage" v-model="message" placeholder="Escribe tu mensaje...">
        <div class="message-actions d-flex align-items-center">
        <i class="speech-to-text bx bx-microphone bx-sm cursor-pointer"></i>
        <label for="attach-doc" class="form-label mb-0">
            <i class="bx bx-paperclip bx-sm cursor-pointer mx-3"></i>
            <input type="file" id="attach-doc" hidden>
        </label>
        <button @click="sendMessage" class="btn btn-primary d-flex">
            <i class="bx bx-paper-plane me-md-1 me-0"></i>
            <span class="align-middle d-md-inline-block d-none">Enviar</span>
        </button>
        </div>
    </div>
    </div>
</template>
<script>

    export default{
        data(){
            return{
                message: ''
            }
        },
        methods:{
            sendMessage(){
               if(!this.message){
                return
               }else{
                this.$emit('message', this.message)
                this.message = ''
               }                
            }
        }
    }

</script>