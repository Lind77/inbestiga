import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'
import Login from '../components/auth/Login.vue'

//Área de Ventas
import HomeSales from '../components/sales/Home.vue'
import MainSales from '../components/sales/Main.vue'

//Área de Ventas - Cotizaciones
import HomeQuotation from '../components/sales/quotations/Home.vue'
import QuotationFile from '../components/sales/quotations/quotationFile.vue'
import ListQuotation from '../components/sales/quotations/List.vue'
import EditQuotation from '../components/sales/quotations/editQuotation.vue'
import QuotationImg from '../components/sales/quotations/quotationImg.vue'

//Área de Ventas - Ordenes
import HomeOrders from '../components/sales/orders/Home.vue'
import OrderFile from '../components/sales/orders/File.vue'

//Área de Ventas - Contratos
import HomeContracts from '../components/sales/contracts/Home.vue'

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

//Área de Ventas - Documentos
import HomeDocuments from '../components/sales/documents/Home.vue'

//Área de Ventas - Precios
import HomePrices from '../components/sales/prices/Home.vue'

//Área de ventas - MyLeads

import HomeMyLeads from '../components/sales/myleads/Home.vue'

// Área Académica
import HomeAcad from '../components/academic/Home.vue'
import MainAcad from '../components/academic/Main.vue'

// Área Académica - Proyectos
import HomeProject  from '../components/academic/projects/Home.vue'
import Kanban from '../components/academic/projects/kanban/Kanban.vue'
import UserAcad from '../components/academic/UserAcad.vue'
import Ecard from '../components/academic/projects/Ecard.vue'
import MyProjects from '../components/academic/projects/MyProjects.vue'

// Área Acádemica - Productos
import HomeProduct from '../components/sales/products/Home.vue'

//Área Acádemica - Teams
import HomeTeams from '../components/academic/teams/Home.vue'

// Área Académica - Colaborators
import HomeCollabs from '../components/academic/collabs/Home.vue'

// Área Administrativa del Sistema
import HomeAdmin from '../components/admin/Home.vue'
import MainAdmin from '../components/admin/Main.vue'

//Área Administrativa - Promociones

import PromosAdmin from '../components/admin/promos/Home.vue'

//Área Administrativa - Comisiones

import HomeComissions from '../components/admin/comissions/Home.vue'

import UsersAdmin from '../components/admin/Users.vue'
import RolesAdmin from '../components/admin/Roles.vue'

import RealTime from '../components/admin/chat/Chat.vue'

//Área de Experiencia
import HomeExperience from '../components/experience/Home.vue'
import MainExperience from '../components/experience/Main.vue'

//Area de Experiencia - Calendly
import HomeCalendly from '../components/experience/calendly/Home.vue'
//Area de Experiencia - Profiles
import HomeProfiles from '../components/experience/profiles/Home.vue'
//Area de Experiencia - Deliveries
import HomeDeliveries from '../components/experience/deliveries/Home.vue'

//Notifications
import Notifications from '../components/layout/Notifications.vue'



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
            },
            {
                path: 'myprojects',
                component: MyProjects,
                name:'my-projects'
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
                path: 'quotations/:idUser',
                component: HomeQuotation,
                props: true,
                name: 'home-quotation'
            },
            {
                path: 'orders/:idUser',
                component: HomeOrders,
                props: true,
                name: 'home-orders'
            },
            {
                path: 'contracts/:idUser',
                component: HomeContracts,
                props: true,
                name: 'home-contracts'
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
            },
            {
                path: 'list-quotations',
                component: ListQuotation,
                name: 'list-quotations'
            },
            {
                path: 'edit-quotation/:idQuot',
                component: EditQuotation,
                props: true,
                name: 'edit-quotation'
            },
            {
                path: 'documents',
                component: HomeDocuments,
                name: 'home-documents'
            },
            {
                path: 'prices',
                component: HomePrices,
                name: 'home-prices'
            },
            {
                path: 'my-leads',
                component: HomeMyLeads,
                name: 'my-leads'
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
                path: 'real-time/:userId',
                component: RealTime,
                name: 'real-time',
                props: true
            },
            {
                path: 'promos-admin',
                component: PromosAdmin,
                name: 'promos-admin',
            },
            {
                path: 'comissions-admin',
                component: HomeComissions,
                name: 'comissions-admin'
            }
        ]
    },
    {
        path: '/experience',
        component: HomeExperience,
        redirect:'/experience/home',
        meta: {requiresAuth:true},
        children:[
            {
                path: 'home',
                component:  MainExperience,
                name: 'main-experience'
            },
            {
                path: 'calendly',
                component: HomeCalendly,
                name: 'home-calendly'
            },
            {
                path: 'profiles',
                component: HomeProfiles,
                name: 'home-profiles'
            },
            {
                path: 'deliveries',
                component: HomeDeliveries,
                name: 'home-deliveries'
            }
        ]
    },
    {
        path: '/notifications/:idUser',
        component: Notifications,
        name: 'notifications',
        meta: {requiresAuth:true},
        props: true
    },
    {
        path: '/quotation-file/:id',
        component:  QuotationFile,
        name: 'quotation-file',
        props: true
    },
    {
        path: '/quotation-img/:id',
        component:  QuotationImg,
        name: 'quotation-img',
        props: true
    },
    {
        path: '/order-file/:id',
        component:  OrderFile,
        name: 'order-file',
        props: true
    },
    {
        path: '/ecard/:id',
        component:  Ecard,
        name: 'ecard',
        props: true
    }
]

