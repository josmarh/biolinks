<template>
    <Header :data="content.data" source="Statistics" />
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import Header from '../../components/report/Header.vue';
import projectlinks from '../../store/projectlinks';

const route = useRoute();
const content = computed(() => projectlinks.state.links);

onMounted(() => {
    projectlinks.dispatch('getLinkInfoId', route.params.id)
})
</script>

<style>

</style>