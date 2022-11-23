<template>
    <div>
        <navbar/>
        <div class="relative md:px-40 px-10 pt-28 bg-slate-100 min-h-screen">
            <!-- Header -->
            <router-view></router-view>
            <Footer/>
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
import Footer from './Footer.vue';
</script>

<style>

</style>