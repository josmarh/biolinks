<template>
    <div class="mt-12">
        
        <div class="w-full p-4 bg-white border 
            border-gray-200 shadow-md sm:p-6 
            md:p-8 dark:bg-gray-800 dark:border-gray-700">
            <form class="space-y-6" @submit.prevent="updateLinkSettings">
                <div>
                    <label for="longUrl" 
                        class="block mb-2 text-sm font-normal flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-arrow-up-right-from-square" class="mt-0.5" />
                        Long Url
                    </label>
                    <input v-model="model.linkTypeUrl"
                        type="url" name="longUrl" id="longUrl" 
                        class="bg-gray-50 border border-gray-300 
                        text-gray-900 text-sm focus:ring-blue-500 
                        focus:border-blue-500 block w-full p-2.5 
                        dark:bg-gray-600 dark:border-gray-500 
                        dark:placeholder-gray-400 dark:text-white" 
                        :placeholder="applink + 'long-url/demo'" required>
                </div>
                <div>
                    <label for="shortUrl" 
                        class="block mb-2 text-sm font-normal flex
                        text-gray-900 dark:text-white capitalize gap-2">
                        <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                        Short Url
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-3 
                            text-sm text-gray-900 bg-gray-200 border 
                            border-r-0 border-gray-300 
                            dark:bg-gray-600 dark:text-gray-400 
                            dark:border-gray-600">
                            {{applink}}
                        </span>
                        <input type="text" id="shortUrl" v-model="model.linkId"
                            class="rounded-none bg-gray-50 
                            border text-gray-900 focus:ring-blue-500 
                            focus:border-blue-500 block flex-1 min-w-0 
                            w-full text-sm border-gray-300 p-2.5 
                            dark:bg-gray-700 dark:border-gray-600 
                            dark:placeholder-gray-400 dark:text-white 
                            dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="alias" required>
                    </div>
                    <p class="text-sm text-gray-500">
                        Leave empty for a random generated one.
                    </p>
                </div>
                
                <!-- Accrodion -->
                <div>
                    <link-accordion title="Schedule" icon="fa-solid fa-clock">
                        <TemporaryURL :data="linkSettings.tempURL" @update-link-setting="updateTempURL" />
                    </link-accordion>

                    <!-- <link-accordion title="Protection" icon="fa-solid fa-user-shield" class="mt-4">
                        <protection :data="linkSettings.protection" @update-link-setting="updateProtection" />
                    </link-accordion>

                    <link-accordion title="Targeting" icon="fa-solid fa-bullseye" class="mt-4">
                        <target :data="linkSettings.target" @update-link-setting="updateTarget" />
                    </link-accordion> -->
                </div>

                <button type="submit" 
                    class="w-full text-white bg-blue-700 
                    hover:bg-blue-800 focus:ring-4 
                    focus:outline-none focus:ring-blue-300 
                    font-medium text-sm px-5 py-2.5 
                    text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                    dark:focus:ring-blue-800">
                    Update
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useRoute } from 'vue-router'
import { notify } from 'notiwind';
import LinkAccordion from './LinkAccordion.vue'
import TemporaryURL from './accordion-body/TemporaryURL.vue'
import Protection from './accordion-body/Protection.vue';
import Target from './accordion-body/Target.vue'
import projectlinks from '../../store/projectlinks';

const route = useRoute()
const props = defineProps({
    data: Object,
});
const emit = defineEmits(['updateLinkInfo']);
const now = new Date();

let applink = `${window.location.protocol}//${window.location.host}/w/`;
let model = ref(props.data)
let linkSettings = ref({
    tempURL: {
        scheduleSwitch: 'no',
        scheduleStart: dformat(now),
        scheduleEnd: dformat(now),
        clickLimit: 5,
        redirectURL: ''
    },
    protection: {
        password: '',
        contentWarning: 'no'
    },
    target: {
        targetType: '',
        country: [],
        device: [],
        browserLang: [],
        os: [],
    }
});

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
})

function updateTempURL(data) {
    linkSettings.value.tempURL = data;
}

function updateProtection(data) {
    linkSettings.value.protection = data;
}

function updateTarget(data) {
    linkSettings.value.target = data;
}

function getLinkSettings() {
    projectlinks
        .dispatch('getLinkSettings', route.params.id)
        .then((res) => {
            linkSettings.value.tempURL.scheduleSwitch = res.data.tempUrlSchedule;
            linkSettings.value.tempURL.scheduleStart = !res.data.tempUrlStartDate ? dformat(now) : res.data.tempUrlStartDate;
            linkSettings.value.tempURL.scheduleEnd = !res.data.tempUrlEndDate ? dformat(now) : res.data.tempUrlEndDate;
            linkSettings.value.tempURL.clickLimit = !res.data.tempUrlClickLimit ? 5 : res.data.tempUrlClickLimit;
            linkSettings.value.tempURL.redirectURL = res.data.tempUrlExpireUrl;
            linkSettings.value.protection.password = res.data.protectionPassword;
            linkSettings.value.protection.contentWarning = res.data.protectionConsentWarning;
            linkSettings.value.target.targetType = !res.data.targetType ? '' : res.data.targetType;
            linkSettings.value.target.country = !res.data.targetCountry  ? [] : JSON.parse(res.data.targetCountry);
            linkSettings.value.target.device = !res.data.targetDevice  ? [] : JSON.parse(res.data.targetDevice);
            linkSettings.value.target.browserLang = !res.data.targetBrowserLang  ? [] : JSON.parse(res.data.targetBrowserLang);
            linkSettings.value.target.os = !res.data.targetOS  ? [] : JSON.parse(res.data.targetOS);
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

function updateLinkSettings() {
    projectlinks
        .dispatch('updateLinkSettings', {
            id: model.value.id,
            linkTypeUrl: model.value.linkTypeUrl,
            linkId: model.value.linkId,
            tempurl_schedule: linkSettings.value.tempURL.scheduleSwitch,
            tempurl_start_date: linkSettings.value.tempURL.scheduleStart,
            tempurl_end_date: linkSettings.value.tempURL.scheduleEnd,
            tempurl_click_limit: linkSettings.value.tempURL.clickLimit,
            tempurl_expire_url: linkSettings.value.tempURL.redirectURL,
            protection_password: linkSettings.value.protection.password,
            protection_consent_warning: linkSettings.value.protection.contentWarning,
            target_type: linkSettings.value.target.targetType,
            target_country: JSON.stringify(linkSettings.value.target.country),
            target_device: JSON.stringify(linkSettings.value.target.device),
            target_browser_lang: JSON.stringify(linkSettings.value.target.browserLang),
            target_os: JSON.stringify(linkSettings.value.target.os),
        })
        .then((res) => {
            emit('updateLinkInfo');
            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);
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

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day} ${time}`;
}

onMounted(() => {
    getLinkSettings();
})
</script>

<style>

</style>