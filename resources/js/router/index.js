import { createRouter, createWebHistory } from 'vue-router'

import Home from '../components/Home.vue'


// Área Académica
import HomeAcad from '../components/academic/Home.vue'
import MainAcad from '../components/academic/Main.vue'

// Área Académica - Proyectos
import HomeProject  from '../components/academic/projects/Home.vue'

// Área Acádemica - Productos
import HomeProduct from '../components/academic/products/Home.vue'

import HomeQuotation from '../components/quotations/Home.vue'

import HomeList from '../components/list/Home.vue'

import HomeOwner from '../components/owners/Home.vue'

const routes = [
    {
        path: '/',
        component: Home,
        name: 'home'
    },
    {
        path: '/acad',
        component: HomeAcad,
        redirect:'/acad/home',
        children:[
            {
                path: 'home',
                component: MainAcad,
                name: 'main-acad'
            },
            {
                path: 'projects',
                component: HomeProject,
                name: 'home-project'
            },
            {
                path: 'quotations',
                component: HomeQuotation,
                name: 'home-quotation'
            },
            {
                path: 'products',
                component: HomeProduct,
                name: 'home-product'
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

//Set the router
const router = createRouter({
    history: createWebHistory(),
    routes,
    linkActiveClass: 'active'
})

export default router