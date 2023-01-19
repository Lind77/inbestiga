<template>
    <div class="card bg-danger mt-2 cursor-pointer" draggable="true" @dragstart="drag" :id="`customer${customer.id}`">
        <div class="card-header text-white fw-300">
            {{ customer.name }}
        </div>
    </div>
</template>
<script>
    export default{
        props:{
            customer: Object
        },
        methods:{
            drag(e){
                e.dataTransfer.setData('text', e.target.id)
                console.log(e.target.id)
            }
        }
    }
</script>