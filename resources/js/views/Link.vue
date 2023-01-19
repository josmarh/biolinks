<template>
    <Header :data="content.data" />

    <!-- Page settings view -->
    <biolink-settings v-if="content.data.type == 'biolink'" :data="content.data" @reload-link-info="getLinkInfo" />

    <link-settings v-if="content.data.type == 'link'" :data="content.data" @update-link-info="getLinkInfo" />
</template>

<script setup>
import Header from '../components/link/Header.vue';
import { onMounted, computed } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import projectlinks from '../store/projectlinks';
import LinkSettings from '../components/link/LinkSettings.vue'
import BiolinkSettings from '../components/link/BiolinkSettings.vue'

const route = useRoute();
const content = computed(() => projectlinks.state.links);

function getLinkInfo() {
    projectlinks
        .dispatch('getLinkInfoId', route.params.linkId)
        .then((res) => {})
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