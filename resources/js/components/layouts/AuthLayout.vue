<template>
    <div>
        <navbar/>
        <div class="relative md:ml-0 bg-slate-100 min-h-screen">
            <!-- Header -->
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue';
</script>

<style>

</style>