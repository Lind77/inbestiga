<template>
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"> Calendario</h4>
      <button class="btn btn-primary" @click="loginCalendly"> Log In Callendly</button>
     <!--  <div class="card p-4">
        <div class="row">
          <div class="col-4">
            <button class="btn btn-primary w-100" @click="addEvent"> <i class="bx bx-plus me-1"></i>Agregar evento</button>
          </div>
          <div class="col-8">
            <FullCalendar :options='calendarOptions' />
          </div>
        </div>
      </div> -->
    </div>
    
</template>
<script>
import FullCalendar from '@fullcalendar/vue3'
import dayGridPlugin from '@fullcalendar/daygrid'
import esLocale from '@fullcalendar/core/locales/es'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  data(){
    return {
      calendarOptions: {
        plugins: [dayGridPlugin, interactionPlugin],
        weekends: true,
        locale: esLocale,
        events: [
          { title: 'Reunión', start: new Date() }
        ],
        editable: true,
        eventBackgroundColor: '#e7e7ff',
        eventTextColor: '#696cff',
        eventDisplay: 'block',
        eventClick: () =>{
          alert('nani')
        },
        displayEventTime: false
      }
    }
  },
  methods:{
    async loginCalendly(){
      const options = {
        method: 'GET',
        url: 'https://auth.calendly.com/oauth/authorize',
        params: {client_id:'riuyagami',response_type: 'code', redirect_uri: 'http://localhost/inbestiga/public/sales/calendars'}
      };

      try {
        const { data } = await axios.request(options);
        console.log(data);
      } catch (error) {
        console.error(error);
      }
    },
    addEvent(){
      this.calendarOptions.events = [...this.calendarOptions.events,{title: 'Otro evento', start: new Date()}]
    }
  }
}
</script>
<style scoped>

</style>