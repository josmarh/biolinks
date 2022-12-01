<template>
    <div class="mt-12">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-7">
                <div class="flex justify-between">
                    <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                        <li class="mr-2">
                            <button @click="selectTab('settings')"
                                class="inline-block py-3 px-4" 
                                aria-current="page"
                                :class="[currentTab==='settings' 
                                ? 'text-white bg-[#234E52] active' 
                                : 'hover:text-gray-900 hover:bg-gray-100']">
                                Settings
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="selectTab('section')"
                                class="inline-block py-3 px-4 
                                dark:hover:bg-gray-800 dark:hover:text-white"
                                :class="[currentTab==='section' 
                                ? 'text-white bg-[#234E52] active' 
                                : 'hover:text-gray-900 hover:bg-gray-100']">
                                Sections
                            </button>
                        </li>
                        <li class="mr-2">
                            <button @click="selectTab('custom')"
                                class="inline-block py-3 px-4  
                                dark:hover:bg-gray-800 dark:hover:text-white"
                                :class="[currentTab==='custom' 
                                ? 'text-white bg-[#234E52] active' 
                                : 'hover:text-gray-900 hover:bg-gray-100']">
                                Custom
                            </button>
                        </li>
                    </ul>
                    <!-- Create section dropdown -->
                    <NewTypeOption />
                </div>
                <div id="tabContent" class="mt-4">
                    <div v-if="currentTab==='settings'">
                        <settings v-if="Object.keys(settings.data).length"
                            :data="model"
                            :data-settings="settings.data"
                            @reload-settings="reloadSettings"
                        />
                    </div>
                    <div v-if="currentTab==='section'">
                        <section />
                    </div>
                    <div v-if="currentTab==='custom'">
                        <custom 
                            :data="customSettings.data" 
                            @reload-settings="reloadSettings"/>
                    </div>
                </div>
            </div>
            <div class="col-span-5">

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, onMounted, onBeforeMount } from 'vue';
import { useRoute } from 'vue-router';
import { notify } from 'notiwind';
import NewTypeOption from './NewTypeOption.vue';
import Settings from './biolink-tabcontent/Settings.vue';
import Section from './biolink-tabcontent/Section.vue';
import Custom from './biolink-tabcontent/Custom.vue';
import projectlinks from '../../store/projectlinks';
import biolinkDefaultSettings from '../../includes/biolink-default-settings'

const route = useRoute()
const settings = computed(() => projectlinks.state.biolinkSettings)
const customSettings = computed(() => projectlinks.state.biolinkCustomSettings)
const props = defineProps({
    data: Object,
});
const emit = defineEmits(['reloadLinkInfo'])
const currentTab = ref('settings');

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true});


function selectTab(tab) {
    currentTab.value = tab;
}

function reloadSettings() {
    projectlinks
        .dispatch('getBiolinkSettings', route.params.id)
    projectlinks
        .dispatch('getBiolinkCustomSettings', route.params.id)
    emit('reloadLinkInfo')
}

function getBiolinkSettings() {
    projectlinks
        .dispatch('getBiolinkSettings', route.params.id)
        .then((res) => {
            getBiolinkCustomSettings();
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

function getBiolinkCustomSettings() {
    projectlinks
        .dispatch('getBiolinkCustomSettings', route.params.id)
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
            }else {
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
    getBiolinkSettings();
});

// onBeforeMount(() => {
//     getBiolinkSettings();
// });
</script>

<style>

</style>