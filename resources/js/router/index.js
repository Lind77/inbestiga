import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'
import Login from '../components/auth/Login.vue'

//Área de Ventas
import HomeSales from '../components/sales/Home.vue'
import MainSales from '../components/sales/Main.vue'


// Área Académica
import HomeAcad from '../components/academic/Home.vue'
import MainAcad from '../components/academic/Main.vue'

// Área Académica - Proyectos
import HomeProject  from '../components/academic/projects/Home.vue'
import Kanban from '../components/academic/projects/kanban/Kanban.vue'

// Área Acádemica - Productos
import HomeProduct from '../components/academic/products/Home.vue'

//Área Acádemica - Teams
import HomeTeams from '../components/academic/teams/Home.vue'

import HomeList from '../components/list/Home.vue'

import HomeOwner from '../components/owners/Home.vue'

// Área Académica - Colaborators
import HomeCollabs from '../components/academic/collabs/Home.vue'



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
            /* {
                path: 'quotations',
                component: HomeQuotation,
                name: 'home-quotation'
            }, */
            {
                path: 'products',
                component: HomeProduct,
                name: 'home-product'
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
            }

        ]
    },
    {
        path: '/sales',
        component: HomeSales,
        redirect:'/sales/home',
        children:[
            {
                path: 'home',
                component: MainSales,
                name: 'main-sales'
            }
        ]
    },
    {
        path: '/list',
        component: HomeList,
        name: 'home-list'
    },
    {
        path: '/owners',
        component: HomeOwner,
        name: 'home-owner'
    }
]

