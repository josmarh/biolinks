<template>
    <router-view></router-view>
    <error-notify/>
    <success-notify/>
</template>

<script setup>
import ErrorNotify from './components/flash-notification/Error.vue';
import SuccessNotify from './components/flash-notification/Success.vue';
import Notifications from 'notiwind'
</script>

<style>

</style>