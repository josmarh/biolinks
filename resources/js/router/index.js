import { createRouter, createWebHistory } from 'vue-router'

import AuthLayout from '../components/layouts/AuthLayout.vue'
import ProjectLayout from '../components/layouts/ProjectLayout.vue'
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
import Users from '../views/admin/Users.vue'
import Reseller from '../views/admin/Reseller.vue'
import Roles from '../views/admin/Roles.vue'
import Permission from '../views/admin/Permission.vue'
import Biolinks from '../views/admin/Biolinks.vue'
import LoginHistory from '../views/admin/LoginHistory.vue'
import Settings from '../views/admin/Settings.vue'
import Projects from '../views/admin/Projects.vue'
import LeadStats from '../views/report/Leads.vue'
import PageViewStats from '../views/report/PageView.vue'
import People from '../views/People.vue'
import ProductCategory from '../views/products/Category.vue'
import ProductCategoryEdit from '../views/products/CategoryEdit.vue'
import ProductCouponCode from '../views/products/CouponCodes.vue'
import ProductSimple from '../views/products/SimpleProduct.vue'
import NewProduct from '../views/products/NewProduct.vue'
import CouponNewForm from '../views/products/CouponForm.vue'
import CouponUpdateForm from '../views/products/CouponForm.vue'
import DesignSetting from '../views/membership/DesignSetting.vue'
import Plans from '../views/membership/Plans.vue'
import Posts from '../views/membership/Posts.vue'
import PostUpdate from '../views/membership/PostEdit.vue'
import Subscribers from '../views/membership/Subscribers.vue'
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
        ]
    },
    {
        path: '/',
        component: ProjectLayout,
        meta: {requiresAuth: true},
        children: [
            {path: '/project/:id', name: 'Project', component: Project},
            {path: '/link/:id', name: 'Link', component: Link},
            {path: '/reseller/users', name: 'Reseller', component: Reseller},
            {path: '/link/:id/leads', name: 'LeadStats', component: LeadStats},
            {path: '/link/:id/statistics', name: 'PageViewStats', component: PageViewStats},
            {path: '/:id/people', name: 'People', component: People},
            {path: '/:id/product/category', name: 'ProductCategory', component: ProductCategory},
            {path: '/:id/product/category/update', name: 'ProductCategoryEdit', component: ProductCategoryEdit},
            {path: '/:id/product/coupon-code', name: 'ProductCouponCode', component: ProductCouponCode},
            {path: '/:id/product/coupon/new', name: 'CouponNewForm', component: CouponNewForm},
            {path: '/:id/product/coupon/update', name: 'CouponUpdateForm', component: CouponUpdateForm},
            {path: '/:id/products', name: 'ProductSimple', component: ProductSimple},
            {path: '/:id/product', name: 'NewProduct', component: NewProduct},
            {path: '/:id/membership/design', name: 'DesignSetting', component: DesignSetting},
            {path: '/:id/membership/plans', name: 'Plans', component: Plans},
            {path: '/:id/membership/posts', name: 'Posts', component: Posts},
            {path: '/:id/membership/post', name: 'PostUpdate', component: PostUpdate},
            {path: '/:id/membership/subscribers', name: 'Subscribers', component: Subscribers},
        ]
    },
    {
        path: '/',
        redirect: '/admin/users',
        component: AdminLayout,
        meta: {requiresAuth: true},
        children: [
            {path: '/admin/users', name: 'Users', component: Users},
            {path: '/admin/roles', name: 'Roles', component: Roles},
            {path: '/admin/permissions', name: 'Permission', component: Permission},
            {path: '/admin/biolinks', name: 'Biolinks', component: Biolinks},
            {path: '/admin/login-history', name: 'LoginHistory', component: LoginHistory},
            {path: '/admin/settings', name: 'Settings', component: Settings},
            {path: '/admin/projects', name: 'Projects', component: Projects},
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
        next({name: 'Login'});
    }else if (store.state.user.token && to.meta.isGuest) {
        next({name: 'Dashboard'});
    }else {
        next();
    }
})

export default router;