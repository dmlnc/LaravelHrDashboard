// import Vue from 'vue'
// import VueRouter from 'vue-router'
import { createWebHistory, createRouter } from "vue-router";

// Vue.use(VueRouter)

let routes = [{
        // will match everything
        path: '/admin/:catchAll(.*)',
        component: () => import('../views/404.vue'),
    },
    {
        path: '/admin/',
        name: 'Home',
        layout: "dashboard",

        redirect: '/admin/dashboard',
        // component: () => import(/* webpackChunkName: "dashboard" */ '../views/Dashboard.vue'),

    },
    {
        path: '/admin/dashboard',
        name: 'Dashboard',
        layout: "dashboard",
        // route level code-splitting
        // this generates a separate chunk (about.[hash].js) for this route
        // which is lazy-loaded when the route is visited.
        component: () => import( /* webpackChunkName: "dashboard" */ '../views/Dashboard.vue'),
    },

    {
        path: '/admin/restaurants',
        name: 'Restaurants-page',
        layout: "dashboard",
        component: () => import( /* webpackChunkName: "restaurants" */ '../views/Restaurants.vue'),
    },

    {
        path: '/admin/vacancies',
        name: 'Vacancies-page',
        layout: "dashboard",
        component: () => import( /* webpackChunkName: "dashboard" */ '../views/Vacancies.vue'),
    },
   

    {
        path: '/admin/users',
        name: 'Users-page',
        layout: "dashboard",
        component: () => import( /* webpackChunkName: "Users" */ '../views/Users.vue'),
    },

    {
        path: '/admin/leads',
        name: 'Leads-page',
        layout: "dashboard",
        component: () => import( /* webpackChunkName: "Users" */ '../views/Leads.vue'),
    },

    {
        path: '/admin/landing',
        name: 'Landing-page',
        layout: "dashboard",
        component: () => import( /* webpackChunkName: "Landing" */ '../views/Landing.vue'),
    },

    {
        path: '/admin/sign-in',
        name: 'Sign-In',
        layout: 'empty',
        component: () => import('../views/Sign-In.vue'),
    },
]

// Adding layout property from each route to the meta
// object so it can be accessed later.
function addLayoutToRoute(route, parentLayout = "default") {
    route.meta = route.meta || {};
    route.meta.layout = route.layout || parentLayout;

    if (route.children) {
        route.children = route.children.map((childRoute) => addLayoutToRoute(childRoute, route.meta.layout));
    }
    return route;
}

routes = routes.map((route) => addLayoutToRoute(route));


const router = createRouter({
    mode: 'hash',
    // base: process.env.BASE_URL,
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
            return {
                selector: to.hash,
                behavior: 'smooth',
            }
        }
        return {
            x: 0,
            y: 0,
            behavior: 'smooth',
        }
    }
});

import AuthUtil from '@/libs/auth/auth';


router.beforeEach((to, from, next) => {
    const isAuthenticated = AuthUtil.checkAuth();
   
    if (!isAuthenticated && to.name !== 'Sign-In') {
        next({ name: 'Sign-In' });
    } else {
        if (isAuthenticated && to.name == 'Sign-In') {
            next({ name: 'Home' });
        } else {
            next();
        }
    }
});


// const router = new VueRouter({
// 	mode: 'hash',
// 	base: process.env.BASE_URL,
// 	routes,
// 	scrollBehavior (to, from, savedPosition) {
// 		if ( to.hash ) {
// 			return {
// 				selector: to.hash,
// 				behavior: 'smooth',
// 			}
// 		}
// 		return {
// 			x: 0,
// 			y: 0,
// 			behavior: 'smooth',
// 		}
// 	}
// })

export default router
