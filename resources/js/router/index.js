import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'
import Login from '../components/auth/Login.vue'

//Área de Ventas
import HomeSales from '../components/sales/Home.vue'
import MainSales from '../components/sales/Main.vue'

//Área de Ventas - Cotizaciones
import HomeQuotation from '../components/sales/quotations/Home.vue'

//Área de Ventas - Clientes
import HomeClient from '../components/sales/customers/Home.vue'

//Área de Ventas - Pre Lead
import HomePreLead from '../components/sales/prelead/Home.vue'

//Área de Ventas - Funnel
import HomeFunnel from '../components/sales/funnel/Home.vue'

//Área de Ventas - Llamadas
import HomeCalls from '../components/sales/calls/Home.vue'

//Área de Ventas - Calendario
import HomeCalendar from '../components/sales/calendar/Home.vue'



// Área Académica
import HomeAcad from '../components/academic/Home.vue'
import MainAcad from '../components/academic/Main.vue'

// Área Académica - Proyectos
import HomeProject  from '../components/academic/projects/Home.vue'
import Kanban from '../components/academic/projects/kanban/Kanban.vue'
import UserAcad from '../components/academic/UserAcad.vue'

// Área Acádemica - Productos
import HomeProduct from '../components/sales/products/Home.vue'

//Área Acádemica - Teams
import HomeTeams from '../components/academic/teams/Home.vue'

// Área Académica - Colaborators
import HomeCollabs from '../components/academic/collabs/Home.vue'

// Área Administrativa del Sistema
import HomeAdmin from '../components/admin/Home.vue'
import MainAdmin from '../components/admin/Main.vue'

import UsersAdmin from '../components/admin/Users.vue'
import RolesAdmin from '../components/admin/Roles.vue'

import RealTime from '../components/admin/chat/Chat.vue'

export const routes = [
    {
        path: '/',
        component: Home,
        redirect: '/login',
        name: 'home'
    },
    {
        path: '/login',
        component: Login,
        name: 'login'
    },
    {
        path: '/acad',
        component: HomeAcad,
        redirect:'/acad/home',
        meta: {requiresAuth:true},
        children:[
            {
                path: 'home',
                component: MainAcad,
                name: 'main-acad'
            },
            {
                path: 'projects',
                component: HomeProject,
                name: 'home-project',

            },
            {
                path: 'kanban/:idProject',
                component: Kanban,
                props: true,
                name: 'kanban'
            },
            {
                path: 'collabs',
                component: HomeCollabs,
                name: 'home-collabs'
            },
            {
                path: 'teams',
                component: HomeTeams,
                name: 'home-teams'
            },
            {
                path: 'user/:idUser',
                component: UserAcad,
                props: true,
                name: 'user-acad'
            }

        ]
    },
    {
        path: '/sales',
        component: HomeSales,
        redirect:'/sales/home',
        meta: {requiresAuth:true},
        children:[
            {
                path: 'home',
                component: MainSales,
                name: 'main-sales'
            },
            {
                path: 'products',
                component: HomeProduct,
                name: 'home-product'
            },
            {
                path: 'quotations',
                component: HomeQuotation,
                name: 'home-quotation'
            },
            {
                path: 'customers',
                component: HomeClient,
                name: 'home-client'
            },
            {
                path: 'prelead',
                component: HomePreLead,
                name: 'home-pre-lead'
            },
            {
                path: 'funnels',
                component: HomeFunnel,
                name: 'home-funnel'
            },
            {
                path: 'calls',
                component: HomeCalls,
                name: 'home-call'
            },
            {
                path: 'calendars',
                component: HomeCalendar,
                name: 'home-calendar'
            }
        ]
    },
    {
        path: '/admin',
        component: HomeAdmin,
        redirect:'/admin/home',
        meta: {requiresAuth:true},
        children:[
            {
                path: 'home',
                component:  MainAdmin,
                name: 'main-admin'
            },
            {
                path: 'users-admin',
                component:  UsersAdmin,
                name: 'users-admin'
            },
            {
                path: 'roles-admin',
                component:  RolesAdmin,
                name: 'roles-admin'
            },
            {
                path: 'real-time',
                component: RealTime,
                name: 'real-time'
            }
        ]
    }
]

