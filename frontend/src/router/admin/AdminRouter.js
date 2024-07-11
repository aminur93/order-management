import Dashboard from "@/views/admin/Dashboard.vue";
import Master from "@/views/admin/Master.vue";
import store from "@/store";
import ProductRouter from "@/router/admin/ProductRouter";
import CustomerRouter from "@/router/admin/CustomerRouter";
import OrderRouter from "@/router/admin/OrderRouter";

export default [
    {
        path: '/dashboard',
        component: Master,
        children: [
            {
                path: '',
                name: 'Dashboard',
                component: Dashboard,
            },

            ...ProductRouter,
            ...CustomerRouter,
            ...OrderRouter

        ],
        beforeEnter(to, from, next){
            if (!store.getters['AuthToken'])
            {
                next({name: 'Login'});
            }else {
                next();
            }
        }
    }
]