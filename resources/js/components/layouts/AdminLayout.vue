<template>
    <div>
        <admin-navbar/>
        <div class="relative lg:px-32 px-10 pt-28 bg-slate-100 min-h-screen">
            <!-- Header -->
            <router-view></router-view>
            <Footer/>
        </div>
    </div>
</template>

<script setup>
import AdminNavbar from './AdminNavbar.vue';
import Footer from './Footer.vue';
</script>

<style>

</style>