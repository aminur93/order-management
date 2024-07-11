import Login from "@/views/admin/auth/Login.vue";
import Register from "@/views/admin/auth/Register.vue";

export default [

    {
        path: '/login',
        name: 'AdminLogin',
        component: Login
    },

    {
        path: '/register',
        name: 'AdminRegister',
        component: Register
    }
];