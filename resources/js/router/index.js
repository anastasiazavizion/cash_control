import { createRouter, createWebHistory } from "vue-router";

import Home from "../Pages/Home.vue";
import Login from "../Pages/Auth/Login.vue";
import Register from "../Pages/Auth/Register.vue";
import Settings from "../Pages/Account/Settings.vue";

const routes = [
    {
        path: '/home',
        component: Home,
        meta: {
            middleware: ["auth"],
        },
    },

    {
        path: '/account/settings',
        name: 'settings',
        component: Settings,
        meta: {
            middleware: ["auth"],
        },
    },

    {
        name:"login",
        path:"/auth/login",
        component:Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }
    },

    {
        name:"register",
        path:"/auth/register",
        component:Register,
        meta:{
            middleware:"guest",
            title:`Register`
        }
    }

];

const router =  createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
   /* const middleware = to.meta.middleware;
    const permissions = window.Laravel.jsPermissions;
    const roles = permissions['roles'];
    const permission = permissions['permissions'];
    if(middleware === "guest" || middleware === undefined){
        next()
    }else{
        let allow = true;
        for(let rule of middleware){
            if(rule.includes('can:')){
                allow = permission.includes(rule.replace('can:',''));
            }else if(rule === 'auth'){
                allow = store.getters['auth/authenticated'];
            }else{
                allow = roles.includes(rule);
            }
            if(!allow){
                break;
            }
        }
        if(allow){
            next()
        }else{
            next({name:"login"})
        }
    }*/
    next()
})

export default router;
