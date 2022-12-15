import { createRouter, createWebHistory } from 'vue-router'

import AuthLayout from '../components/layouts/AuthLayout.vue'
import GuestLayout from '../components/layouts/GuestLayout.vue'
import AdminLayout from '../components/layouts/AdminLayout.vue'
import Register from '../views/auth/Register.vue'
import MemberRegister from '../views/auth/MemberRegister.vue'
import Login from '../views/auth/Login.vue'
import Account from '../views/auth/Account.vue'
import ForgotPassword from '../views/auth/ForgotPassword.vue'
import ResetPassword from '../views/auth/ResetPassword.vue'
import Dashboard from '../views/Dashboard.vue'
import Project from '../views/Project.vue'
import Link from '../views/Link.vue'
import Qrcode from '../views/Qrcode.vue'
import store from '../store'

const routes = [
    {
        path: '/',
        redirect: '/login',
        component: GuestLayout,
        meta: {isGuest: true},
        children: [
            {path: '/login', name: 'Login', component: Login},
            {path: '/ext/register', name: 'Register', component: Register},
            {path: '/register/:id', name: 'MemberRegister', component: MemberRegister},
            {path: '/forgot-password', name: 'ForgotPassword', component: ForgotPassword},
            {path: '/reset-password/:email', name: 'ResetPassword', component: ResetPassword},
        ]
    },
    {
        path: '/',
        redirect: '/dashboard',
        component: AuthLayout,
        meta: {requiresAuth: true},
        children: [
            {path: '/dashboard', name: 'Dashboard', component: Dashboard},
            {path: '/account', name: 'Account', component: Account},
            {path: '/project/:id', name: 'Project', component: Project},
            {path: '/link/:id', name: 'Link', component: Link},
        ]
    },
    {path: '/:linkid/qr', name: 'Qrcode', component: Qrcode},
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

// handling user auth
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({name: 'Login'})
    }else if (store.state.user.token && to.meta.isGuest) {
        next();
    }else {
        next();
    }
})

export default router;