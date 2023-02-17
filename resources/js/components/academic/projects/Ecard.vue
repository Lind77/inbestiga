<template>
    <div class="content">
        <div class="card-body">
            <img src="https://inbestiga.com/pdf-sys/logo-blanco.png" class="logo">
            <div class="middle">
                <img src="https://inbestiga.com/pdf-sys/e-card.png" class="resource w-75">
                <p class="code w-50">B{{this.month}}{{ this.year }} - 000{{ this.$route.params.id }}</p>
            </div>
            <div class="footer">
                <div class="info-footer">
                    <p>Atención al Cliente</p>
                    <p>998 332 767</p>
                </div>
                <p class="web">WWW.INBESTIGA.COM</p>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment"
export default {
    data(){
       return{
            year: moment(new Date()).format('YY'),
            month: moment(new Date()).format('MM')
       }
    },
    methods:{
        print(){
        }
    },
    mounted(){
        this.print()
    }
}
</script>
<style scoped>
    *{
        font-family: 'Montserrat', sans-serif !important;
    }
    .content{
        background-color: #fff;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0px 10px 0px 10px;
    }
    .card-body{
        padding: 15px;
        background-color: #1f1f1f;
        width: 50%;
        height: auto;
        border-radius: 10px;
        margin: 0px 250px 0px 250px;
    }
    .logo{
        width: 180px;
        margin-left: 10px;
    }
    .middle{
        display: flex;
        justify-content: center;
        align-items: center;
        justify-content: start;
    }
    .resource{
        width: 550px;
        margin-bottom: 0px;
    }
    .code{
        font-size: 40px;
        font-weight: 700;
        color: #fff;
        margin-left: -15%;
    }
    .info-footer{
        font-weight: 600;
        font-size: 20px;
    }
    .info-footer p{
        margin-bottom: 1px;
    }
    .web{
        font-size: 20px;
        font-weight: 500;
        margin-bottom: 0px;
    }
    .footer{
        display: flex;
        justify-content: space-between;
        align-items: end;
        color: #fff;
        margin-left: 10px;
    }
</style>