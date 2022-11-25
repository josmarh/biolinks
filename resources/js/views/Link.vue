<template>
    <Header :data="content.data" />
</template>

<script setup>
import Header from '../components/link/Header.vue';
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import projectlinks from '../store/projectlinks';

const route = useRoute();
const content = computed(() => projectlinks.state.links)

function getLinkInfo() {
    projectlinks
        .dispatch('getLinkInfoId', route.params.id)
        .then((res) => {

        })
        .catch((err) => {
            let errMsg;
            if(err.response) {
                if (err.response.data) {
                    if (err.response.data.hasOwnProperty("message"))
                        errMsg = err.response.data.message;
                    else
                        errMsg = err.response.data.error;
                }
            }else{
                errMsg = err;
            }
            notify({
                group: "error",
                title: "Error",
                text: errMsg
            }, 4000);
        })
}

onMounted(() => {
    getLinkInfo();
})
</script>

<style>

</style>