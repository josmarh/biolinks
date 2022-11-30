<template>
    <div class="block p-6 bg-white border 
        border-gray-200 shadow-md dark:bg-gray-800 
        dark:border-gray-700 dark:hover:bg-gray-700">
        <form @submit.prevent="updateBiolinkCustomSettings">
            <div>
                <label for="header" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    <font-awesome-icon icon="fa-solid fa-pen-nib" />
                    Header Script
                </label>
                <textarea id="header" rows="4" v-model="model.headerScript"
                    class="block p-2.5 w-full text-sm text-gray-900 
                    bg-gray-50 border border-gray-300 
                    focus:ring-blue-500 focus:border-blue-500 
                    dark:bg-gray-700 dark:border-gray-600 
                    dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder=""></textarea>
            </div>
            <div class="mt-6">
                <label for="footer" 
                    class="block mb-2 text-sm font-medium 
                    text-gray-900 dark:text-white">
                    <font-awesome-icon icon="fa-solid fa-pen-nib" />
                    Footer Script
                </label>
                <textarea id="footer" rows="4" v-model="model.footerScript"
                    class="block p-2.5 w-full text-sm text-gray-900 
                    bg-gray-50 border border-gray-300 
                    focus:ring-blue-500 focus:border-blue-500 
                    dark:bg-gray-700 dark:border-gray-600 
                    dark:placeholder-gray-400 dark:text-white 
                    dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                    placeholder=""></textarea>
            </div>
            <button type="submit" 
                class="w-full text-white bg-blue-700 
                hover:bg-blue-800 focus:ring-4 mt-6
                focus:outline-none focus:ring-blue-300 
                font-medium text-sm px-5 py-2.5 
                text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                dark:focus:ring-blue-800">
                Update
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import projectlinks from '../../../store/projectlinks'

const route = useRoute()
const props = defineProps({
    data: Object
})

let model = ref({
    headerScript: null,
    footerScript: null,
    linkId: route.params.id
})
let isDisabled = ref(false)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateBiolinkCustomSettings() {
    isDisabled.value = true;
    projectlinks
        .dispatch('updateBiolinkCustomSettings', model.value)
        .then((res) => {
            isDisabled.value = false;
            projectlinks.dispatch('getBiolinkCustomSettings');
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
        })
        .catch((err) => {
            isDisabled.value = false;
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
</script>

<style>

</style>