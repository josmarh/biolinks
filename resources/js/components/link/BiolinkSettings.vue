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
                        <settings 
                            :data="model" 
                            :data-settings="biolinkSettings" 
                            @update-settings="updateSettings" 
                        />
                    </div>
                    <div v-if="currentTab==='section'">
                        <section />
                    </div>
                    <div v-if="currentTab==='custom'">
                        <custom :data="customSettings.data" />
                    </div>
                </div>
            </div>
            <div class="col-span-5">

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import NewTypeOption from './NewTypeOption.vue';
import Settings from './biolink-tabcontent/Settings.vue';
import Section from './biolink-tabcontent/Section.vue';
import Custom from './biolink-tabcontent/Custom.vue';
import projectlinks from '../../store/projectlinks';

const route = useRoute()
const customSettings = computed(() => projectlinks.state.biolinkCustomSettings)
const props = defineProps({
    data: Object,
});
const currentTab = ref('settings');

let model = ref(props.data)
let biolinkSettings = ref({
    topLogo: null,
    video: { type: 'youtube', link: '' },
    title: 'My Featured Links 🔥',
    description: '',
    textColor: '#ffffff',
    verifiedCheckmark: 'no',
    bckgdType: 'preset',
    bckgd: {
        presetbckg: 'background-image: linear-gradient(109.6deg, #ffb418 11.2%, #f73131 91.1%);',
        color: '#808080',
        grad1: '#808080',
        grad2: '#808080',
        image: null
    },
    branding: {
        display: 'no',
        name: '',
        url: '',
    },
    analytics: {
        googleId: '',
        fbPixel: ''
    },
    seo: {
        title: '',
        metaDesc: '',
        favicon: null
    },
    utmParams: {
        medium: '',
        source: ''
    },
    socials: {
        buttonColor: '#ffffff',
        email: '',
        phone: '',
        whatsapp: '',
        facebook: '',
        fbMessager: '',
        instagram: '',
        twitter: '',
        tiktok: '',
        youtube: '',
        soundcloud: '',
        linkedin: '',
        spotify: '',
        pinterest: '',
        clubhouse: ''
    },
    fonts: 'lato',
    sections: ['lead_generation'],
    custom: {
        header: null,
        footer: null,
    }
});

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
});

function selectTab(tab) {
    currentTab.value = tab;
}

function updateSettings(model, settings) {
    model.value = model
    biolinkSettings.value = settings
}

function updateBiolinkSettings() {

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