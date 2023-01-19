<template>
    <Header :data="content.data" source="Leads" />

    <lead-list :linkInfo="content.data" />
</template>

<script setup>
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import Header from '../../components/report/Header.vue';
import LeadList from '../../components/report/LeadList.vue';
import projectlinks from '../../store/projectlinks';

const route = useRoute();
const content = computed(() => projectlinks.state.links);

onMounted(() => {
    projectlinks.dispatch('getLinkInfoId', route.params.linkId)
})
</script>

<style>

</style>