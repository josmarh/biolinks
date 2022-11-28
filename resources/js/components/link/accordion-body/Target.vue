<template>
    <div class="px-6 py-4">
        <div>
            <label for="target-type" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                <font-awesome-icon icon="fa-solid fa-bullseye" />
                Targeting type
            </label>
            <select id="target-type" v-model="model.targetType"
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 
                dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">None</option>
                <option value="country">Country</option>
                <option value="device">Device Type</option>
                <option value="blang">Browser Language</option>
                <option value="OS">Operating System</option>
            </select>
        </div>
        <div class="mt-2">
            <div v-if="model.targetType == 'country'">
                <p class="flex gap-2 text-gray-500 text-sm">
                    Send visitors to different URLs based on their country location.
                </p>
                <country class="mt-4" 
                    :countries="countries"
                    :added-countries="model.country" 
                    @add-country="createTargetType" 
                    @update-country="updateTargetType" />
            </div>
            <div v-if="model.targetType == 'device'">
                <p class="flex gap-2 text-gray-500 text-sm">
                    Send visitors to different URLs based on the device that they are using.
                </p>
                <devices class="mt-4"
                    :added-devices="model.device"
                    @add-device="createTargetType"
                    @update-device="updateTargetType"/>
            </div>
            <div v-if="model.targetType == 'blang'">
                <p class="flex gap-2 text-gray-500 text-sm">
                    Send visitors to different URLs based on their main browser language.
                </p>
                <browser-lang class="mt-4"
                    :added-blangs="model.browserLang"
                    :languages="languages"
                    @addBlang="createTargetType"
                    @updateBlang="updateTargetType"/>
            </div>
            <div v-if="model.targetType == 'OS'">
                <p class="flex gap-2 text-gray-500 text-sm">
                    Send visitors to different URLs based on the device operating system that they are using.
                </p>
                <OS class="mt-4" :addedOS="model.os" @addOS="createTargetType" @updateOS="updateTargetType" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted, computed } from 'vue';
import Country from '../target-types/Country.vue';
import Devices from '../target-types/Devices.vue';
import BrowserLang from '../target-types/BrowserLang.vue';
import OS from '../target-types/OS.vue';
import store from '../../../store';
import helper from '../../../helpers';

const countries = computed(() => store.state.countries)
const languages = computed(() => store.state.languages)
const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateLinkSetting']);

let model = ref(props.data)

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep:true})

function createTargetType() {
    switch (model.value.targetType) {
        case 'country':
            model.value.country.push({country: 'AF', url: ''});
            break;

        case 'device':
            model.value.device.push({device: 'desktop', url: ''});
            break;

        case 'blang':
            model.value.browserLang.push({lang: 'en', url: ''});
            break;

        case 'OS':
            model.value.os.push({os: 'iOS', url: ''});
            break;
    
        default:
            break;
    };
    emit('updateLinkSetting', model.value)
}

function updateTargetType(data) {
    switch (model.value.targetType) {
        case 'country':
            model.value.country = data;
            break;

        case 'device':
            model.value.device = data;
            break;

        case 'blang':
            model.value.browserLang = data;
            break;

        case 'OS':
            model.value.os = data;
            break;
    
        default:
            break;
    }
    emit('updateLinkSetting', model.value)
}

onMounted(() => {
    helper.getCountries();
    helper.getLanguages();
})
</script>
