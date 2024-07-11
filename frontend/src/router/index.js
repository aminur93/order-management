import { createWebHistory, createRouter} from "vue-router";
import AdminRouter from "@/router/admin/AdminRouter";
import AuthRouter from "@/router/auth/AuthRouter";

const routes = [
    ...AuthRouter,
    ...AdminRouter
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;