<template>
    <div class="bg-black h-screen flex justify-center pt-28">
        <vue-qrcode v-if="isQrcodeSet==2"
            :value="applink" 
            :options="{ width: 350 }" 
        ></vue-qrcode>
    </div>
</template>

<script setup> 
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { notify } from 'notiwind';
import VueQrcode from '@chenfengyuan/vue-qrcode';
import projectlinks from '../store/projectlinks';

const route = useRoute();
const router = useRouter();
const linkId = route.params.linkid;
const isQrcodeSet = ref(0)
let applink = `${window.location.protocol}//${window.location.host}/${linkId}`;

function getQrcode() {
    projectlinks
        .dispatch('getLinkInfo', linkId)
        .then((res) => {
            if(res.data.status == 'inactive') {
                router.push({name: 'Dashboard'});
            }else {
                isQrcodeSet.value = 2
            }
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
    getQrcode();
})
</script>

<style>

</style>