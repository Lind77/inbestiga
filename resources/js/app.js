import { createApp } from 'vue'

import { createRouter, createWebHistory } from 'vue-router'

import { routes } from './router'

import App from './App.vue'

import * as Vue from 'vue'

import './bootstrap'

import axios from 'axios'

axios.defaults.baseURL = import.meta.env.VITE_AXIOS_URL

import VueSweetalert2 from 'vue-sweetalert2'

import 'sweetalert2/dist/sweetalert2.min.css'

import * as swal from 'sweetalert2';

import { createPinia } from 'pinia'

import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'

import VueAxios from 'vue-axios'

import VueApexCharts from 'vue3-apexcharts'

function loggedIn(){
    return localStorage.getItem('token')
}

const pinia = createPinia()
  pinia.use(piniaPluginPersistedstate)
  const app = createApp(App)
app.use(pinia)

import { userStore } from './stores/UserStore'
import { useNotificationStore  } from './stores/Notifications'
import { useMessageStore } from './stores/MessageStore'

const store = userStore();
const notificationStore = useNotificationStore();
const messageStore = useMessageStore();

//Set the router
const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_ROOT_VUE),
    routes,
    linkActiveClass: 'active'
})

router.beforeEach((to, from, next) => {
    var element = document.getElementsByClassName('modal-backdrop')
    if(element.length != 0){
        element[0].classList.remove("show")
        element[0].classList.remove("fade")
        element[0].classList.remove("modal-backdrop")
    }
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!loggedIn()) {
            next({
            path: '/',
            query: { redirect: to.fullPath }
            })
        } else {
            console.log("test");
            Echo.private(`message.${store.authUser.id}`).listen(
                "NewMessage",
                (e) => {
                    messageStore.addMessage({
                        message: e.message,
                        type: 'info', // o el tipo de notificación que desees manejar
                    });
                }
            );
            next()
        }
    } else if(to.matched.some(record => record.meta.guest)){
        if (loggedIn()) {
            next({
            path: '/',
            query: { redirect: to.fullPath }
            })
        } else {
            next()
        }
    }else{
        next() // make sure to always call next()!
    }
  })

  

  app.use(VueApexCharts)
  app.use(VueSweetalert2)
  
  app.use(router)
  app.use(VueAxios, axios)

  app.mount('#app')