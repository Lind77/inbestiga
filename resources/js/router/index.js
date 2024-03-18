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
import CreateOrder from '../components/sales/orders/Create.vue'
import OrderFile from '../components/sales/orders/File.vue'

//Área de Ventas - Contratos
import HomeContracts from '../components/sales/contracts/Home.vue'
import EditContracts from '../components/sales/contracts/EditContract.vue'
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
import HomeMakeDocs from '../components/sales/makedocs/Home.vue'
import ViewDocs from '../components/sales/makedocs/View.vue'

//Área de Ventas - Precios
import HomePrices from '../components/sales/prices/Home.vue'

//Área de ventas - MyLeads
import HomeMyLeads from '../components/sales/myleads/Home.vue'

//Área de ventas - Voucher
import HomeVoucher from '../components/sales/voucher/Home.vue'
import FileVoucher from '../components/sales/voucher/File.vue'

// Área Académica
import HomeAcad from '../components/academic/Home.vue'
import MainAcad from '../components/academic/Main.vue'

// Área Académica - Proyectos
import HomeProject  from '../components/academic/projects/Home.vue'
import Kanban from '../components/academic/projects/kanban/Kanban.vue'
import UserAcad from '../components/academic/UserAcad.vue'
import Ecard from '../components/academic/projects/Ecard.vue'
import MyProjects from '../components/academic/projects/MyProjects.vue'
import AcadProfile from '../components/academic/projects/Profile.vue'
import ShowProject from '../components/academic/projects/ShowProject.vue'

// Área Acádemica
import HomeProduct from '../components/sales/products/Home.vue'

//Área Acádemica - Teams
import HomeTeams from '../components/academic/teams/Home.vue'

// Área Académica - Colaborators
import HomeCollabs from '../components/academic/collabs/Home.vue'

//Area Académica - Archivos
import Files from '../components/academic/files/Home.vue'

//Area Académica - Notion
import HomeNotion from '../components/academic/notion/Home.vue'

// Área Administrativa del Sistema
import HomeAdmin from '../components/admin/Home.vue'
import MainAdmin from '../components/admin/Main.vue'

//Área Administrativa - Promociones
import PromosAdmin from '../components/admin/promos/Home.vue'

//Área Administrativa - Comisiones
import HomeComissions from '../components/admin/comissions/Home.vue'

//Área Administrativa - Permisos
import HomePermissions from '../components/admin/permissions/Home.vue'

import UsersAdmin from '../components/admin/users/Users.vue'
import RolesAdmin from '../components/admin/roles/Roles.vue'
import AreasAdmin from '../components/admin/areas/Areas.vue'
import SubareasAdmin from '../components/admin/subareas/Home.vue'

import RealTime from '../components/admin/chat/Chat.vue'

import HomeChart from '../components/admin/chart/Home.vue'

//Área de Marketing
import HomeMarketing from '../components/marketing/Home.vue'
import MainMarketing from '../components/marketing/Main.vue'

//Área de Experiencia
import HomeExperience from '../components/experience/Home.vue'
import MainExperience from '../components/experience/Main.vue'

//Area de Experiencia - Calendly
import HomeCalendly from '../components/experience/calendly/Home.vue'
//Area de Experiencia - Horarios
import HomeSchedule from '../components/experience/schedules/Home.vue'
//Area de Experiencia - Asistencias
import HomeAttendance from '../components/experience/attendances/Home.vue'
//Area de Experiencia - Profiles
import HomeProfiles from '../components/experience/profiles/Home.vue'
//Area de Experiencia - Deliveries
import HomeDeliveries from '../components/experience/deliveries/Home.vue'
//Area de Experiencia - Comunications
import HomeComunications from '../components/experience/comunication/Home.vue'
//Area de Experiencia - Solicitudes
import HomeRequests from '../components/experience/requests/Home.vue'
//Area de Experiencia - Documentacion
import HomeDocumentation from '../components/experience/profiles/Documentation.vue'

//Área para los usuarios
import UsersLogin from '../components/user/Login.vue'
import HomeUser from '../components/user/HomeUser.vue'
import DocumentationUser from '../components/user/DocumentationUser.vue'

//Notifications
import Notifications from '../components/layout/Notifications.vue'
//Profile
import Profile from '../components/profile/Home.vue'

//Trabajos
import Jobs from '../components/jobs/Home.vue'

//SandBox
import Sandbox from '../components/admin/sandbox/Home.vue'

export const routes = [
    {
        path: '/',
        component: Login,
        name: 'login'
    },
    {
        path: '/user',
        component: UsersLogin,
        name: 'user-login'
    },
    {
        path: '/home-user/:customerId',
        component: HomeUser,
        name: 'home-user',
        props: true
    },
    {
        path: '/user-documentation/:quotationId',
        component: DocumentationUser,
        name: 'user-documentation',
        props: true
    },
    {
        path: '/home',
        component: Home,
        name: 'home',
        meta: {requiresAuth:true},
        children:[
            {
                path: 'sales',
                component: MainSales,
                name: 'main-sales'
            },
            {
                path: 'vouchers',
                component: HomeVoucher,
                name: 'vouchers'
            },
            {
                path: 'prices',
                component: HomePrices,
                name: 'home-prices'
            },
            {
                path: 'customers',
                component: HomeClient,
                name: 'home-client'
            },
            {
                path: 'prelead/:userId?',
                props:true,
                component: HomePreLead,
                name: 'home-pre-lead'
            },
            {
                path: 'funnels/:userId?',
                component: HomeFunnel,
                props:true,
                name: 'home-funnel'
            },
            {
                path: '/makeDocs/:customerId?/:quotationId?',
                component: HomeMakeDocs,
                props: true,
                name: 'home-docs'
            },
            {
                path: 'calls',
                component: HomeCalls,
                name: 'home-call'
            },
            {
                path: 'documents',
                component: HomeDocuments,
                name: 'home-documents'
            },
            {
                path: 'my-leads',
                component: HomeMyLeads,
                name: 'my-leads'
            },
            {
                path: 'real-time/:userId',
                component: RealTime,
                name: 'real-time',
                props: true
            },
            {
                path: 'users-admin',
                component:  UsersAdmin,
                name: 'users-admin'
            },
            {
                path: 'areas-admin',
                component:  AreasAdmin,
                name: 'areas-admin'
            },
            {
                path: 'subareas-admin',
                component: SubareasAdmin,
                name: 'subareas-admin'
            },
            {
                path: 'roles-admin',
                component:  RolesAdmin,
                name: 'roles-admin'
            },
            {
                path: 'permissions-admin',
                component: HomePermissions,
                name: 'permissions-admin'
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
            },
            {
                path: 'vouchers',
                component: HomeVoucher,
                name: 'vouchers'
            },
            {
                path: 'super-chart',
                component: HomeChart,
                name: 'super-chart'
            },
            {
                path:'attendance',
                component: HomeAttendance,
                name:'home-attendance'
            },
            {
                path: 'requests',
                component:  HomeRequests,
                name: 'home-requests'
            },
            {
                path:'schedule',
                component: HomeSchedule,
                name: 'home-schedule'
            },
            {
                path: 'calendly',
                component: HomeCalendly,
                name: 'home-calendly'
            },
            {
                path: 'deliveries',
                component: HomeDeliveries,
                name: 'home-deliveries'
            },
            {
                path: 'profiles',
                component: HomeProfiles,
                name: 'home-profiles'
            },
            {
                path: 'projects',
                component: HomeProject,
                name: 'home-project',
            },
            {
                path: 'profile/:idProject',
                component: AcadProfile,
                props: true,
                name: 'profile-acad'
            },
            {
                path: 'teams',
                component: HomeTeams,
                name: 'home-teams'
            },
            {
                path: 'documentation/:quotationId',
                component: HomeDocumentation,
                name: 'home-documentation',
                props: true
            },
            {
                path: '/profile/:idUser',
                component: Profile,
                name: 'profile',
                meta: {requiresAuth:true},
                props: true
            },
            {
                path: 'files',
                component: Files,
                name: 'files'
            },
            {
                path: 'kanban/:idProject',
                component: Kanban,
                props: true,
                name: 'kanban'
            },
            {
                path: 'project/:idProject',
                component: ShowProject,
                props: true,
                name: 'project'
            },
            {
                path: 'myprojects',
                component: MyProjects,
                name: 'myprojects'
            },
            {
                path: 'sandbox',
                component: Sandbox,
                name: 'sandbox'
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
        path: '/voucher-file/:voucherId',
        component: FileVoucher,
        name: 'voucher-file',
        props: true
    }
]

