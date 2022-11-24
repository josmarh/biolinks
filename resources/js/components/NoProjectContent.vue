<template>
    <img :src="appurl + '/temps/7465691.png'" alt="" class="mx-auto w-28 h-28">
    <p class="text-center mt-4 text-gray-500 text-2xl">{{notice}}</p>
</template>

<script setup>
const props = defineProps({
    notice: String
})
const appurl = `${window.location.protocol}//${window.location.host}`
</script>