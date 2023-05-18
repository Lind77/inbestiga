<template>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ store.authUser?store.authUser.name:'' }}, te damos la bienvenida 🎉</h5>
                        <p class="mb-4">Tienes <span class="fw-bold">{{ comunications.length }}</span> comunicaciones pendientes para hoy, te recomendamos revisarlas.</p>

                    </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/illustrations/man-with-laptop-light.png" height="140" alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png" data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 order-4 order-lg-3 ">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title m-0 me-2">Comunicaciones Pendientes</h5>
      </div>
      <div class="card-body">
        
        <!-- Activity Timeline -->
        <ul class="timeline">
          <li class="timeline-item timeline-item-transparent" v-for="comunication in comunications">
            <span class="timeline-point timeline-point-primary"></span>
            <div class="timeline-event">
              <div class="timeline-header mb-1">
                <h6 class="mb-0">{{ comunication.customer.name }} - {{ comunication.customer.user?comunication.customer.user.name:'' }}</h6>
                <small class="text-muted">{{ formatTime(comunication.time) }}</small>
              </div>
              <p>{{ comunicationType[comunication.type] }}</p>
              <p class="mb-2">{{ comunication.comment }}</p>
            </div>
          </li>
        </ul>
        <!-- /Activity Timeline -->
      </div>
    </div>
  </div>
        </div>
    </div>
</template>
<script>
import moment from 'moment';
import { userStore } from '../../stores/UserStore';
import axios from 'axios';

export default{
    data(){
        return{
            comunicationType:{
                1: 'Llamar',
                2: 'Escribir',
                3: 'Meet'
            },
            comunications:[],
            time:'',
            interval:null
        }
    },
    setup(){
      const store = userStore()
      return { store }
    },
    methods:{
        formatTime(time) {
            const hours = time.split(":")[0]
            const minutes = time.split(":")[1]
            return `${hours}:${minutes}`
        },
        getComunicationsByToday(){
            axios.get('/api/getComunicationsByToday/'+this.store.authUser.id)
            .then((res)=>{
                this.comunications = res.data
            })
        },
        startInterval(){
            this.interval = setInterval(()=>{
                this.verifyComunication()
            }, 60000)
        },
        verifyComunication(){
            var timeMinutes = moment().format('HH:mm')
            var timeSeconds = timeMinutes+':00'

            var modifiedTime = moment(timeSeconds, 'HH:mm').add(1, 'hour').format('HH:mm')

            var comunicationPlusHourFound = this.comunications.find(comunication => comunication.time == modifiedTime+':00')

            if(comunicationPlusHourFound){

                const fd = new FormData()
                fd.append('customerName', comunicationPlusHourFound.customer.name)
                fd.append('owner', comunicationPlusHourFound.customer.user_id)

                axios.post('/api/addNotificationComunication', fd)
                .then((res) =>{
                    console.log(res)
                })
                .catch((err) =>{
                    console.error(err)
                })
            }

            console.log(comunicationPlusHourFound)

            var comunicationFound = this.comunications.find(comunication => comunication.time == timeSeconds)
            
            if(comunicationFound && this.store.authUser.roles[0].name == 'Seller'){
                this.$swal('Usted tiene una comuniación pendiente en estos momentos con ' + comunicationFound.customer.name)
            }
            
        }
    },
    mounted(){
        this.startInterval()
        this.getComunicationsByToday()
    }
}
</script>
<style scoped>
.timeline {
    position: relative;
    height: 100%;
    width: 100%;
    padding: 0;
    list-style: none
}

.timeline::before {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    height: 100%;
    width: 1px;
    border: 0;
    border-left: 1px solid #d9dee3;
    content: ""
}

.timeline .timeline-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-direction: row
}

.timeline .timeline-header>*:first-child {
    margin-right: .5rem
}

.timeline .timeline-end-indicator {
    position: absolute;
    bottom: -1.35rem;
    left: -0.65rem
}

.timeline .timeline-end-indicator i {
    font-size: 1.5rem;
    color: #d9dee3
}

.timeline .timeline-label {
    position: relative;
    z-index: 2;
    display: block;
    text-align: left;
    margin-left: -1.5rem;
    margin-bottom: 1rem
}

.timeline.timeline-solid:before {
    border-style: solid
}

.timeline.timeline-dotted:before {
    border-style: dotted
}

.timeline.timeline-dashed:before {
    border-style: dashed
}

.timeline.timeline-hidden:before {
    border-style: none
}

.timeline .timeline-item {
    position: relative;
    padding-left: 3rem
}

.timeline .timeline-item .timeline-event {
    position: relative;
    top: -1rem;
    width: 100%;
    min-height: 4rem;
    background-color: #fff;
    border-radius: .375rem;
    padding: 1.25rem 1.5rem
}

.timeline .timeline-item .timeline-event:before {
    position: absolute;
    top: .75rem;
    left: 32px;
    right: 100%;
    width: 0;
    height: 0;
    border-top: 1rem solid rgba(0,0,0,0);
    border-right: 1rem solid;
    border-left: 0 solid;
    border-bottom: 1rem solid rgba(0,0,0,0);
    border-left-color: #fff;
    border-right-color: #fff;
    margin-left: -3rem;
    content: ""
}

.timeline .timeline-item .timeline-event:after {
    position: absolute;
    top: .75rem;
    left: -17px;
    width: 0;
    height: 0;
    border-top: 1rem solid rgba(0,0,0,0);
    border-right: 1rem solid;
    border-left: 0 solid;
    border-bottom: 1rem solid rgba(0,0,0,0);
    border-left-color: #fff;
    border-right-color: #d9dee3;
    z-index: -1;
    content: ""
}

.timeline .timeline-item .timeline-event.timeline-event-shadow {
    box-shadow: 0 .5rem 1rem rgba(67,89,113,.075) !important
}

.timeline .timeline-item .timeline-event .timeline-event-time {
    position: absolute;
    top: 1.2rem;
    font-size: .85rem;
    color: #a1acb8
}

.timeline .timeline-item .timeline-indicator {
    position: absolute;
    left: -0.6875rem;
    top: 0;
    z-index: 2;
    display: block;
    height: 1.5rem;
    width: 1.5rem;
    text-align: center;
    border-radius: 50%;
    border: 2px solid #696cff;
    background-color: #f5f5f9 !important
}

.timeline .timeline-item .timeline-indicator i {
    color: #696cff;
    font-size: .85rem;
    vertical-align: baseline
}

.timeline .timeline-item .timeline-point {
    position: absolute;
    left: -0.312rem;
    top: 0;
    z-index: 2;
    display: block;
    height: .75rem;
    width: .75rem;
    border-radius: 50%;
    background-color: #696cff
}

.timeline .timeline-item.timeline-item-transparent .timeline-event {
    top: -1.4rem;
    background-color: rgba(0,0,0,0)
}
</style>