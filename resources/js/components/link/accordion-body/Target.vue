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
                <option value="browser-lang">Brwoser Language</option>
                <option value="OS">Operating System</option>
            </select>
        </div>
        <div class="mt-2">
            <p v-if="model.targetType == 'country'"
                class="flex gap-2 text-gray-500 text-sm">
                Send visitors to different URLs based on their country location.
            </p>
            <p v-if="model.targetType == 'device'"
                class="flex gap-2 text-gray-500 text-sm">
                Send visitors to different URLs based on the device that they are using.
            </p>
            <p v-if="model.targetType == 'browser-lang'"
                class="flex gap-2 text-gray-500 text-sm">
                Send visitors to different URLs based on their main browser language.
            </p>
            <p v-if="model.targetType == 'OS'"
                class="flex gap-2 text-gray-500 text-sm">
                Send visitors to different URLs based on the device operating system that they are using.
            </p>
        </div>
        <div>

        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateLinkSetting']);

let model = ref({
    targetType: '',
    country: [],
    device: [],
    browserLang: [],
    os: [],
})

watch(model, (newVal, oldVal) => {
    emit('updateLinkSetting', model.value)
}, {deep: true});


function createTargetType() {
    switch (model.value.targetType) {
        case 'country':
            model.value.country.push({country: 'AF', url: ''});
            break;

        case 'device':
            model.value.device.push({device: 'Desktop', url: ''});
            break;

        case 'browser-lang':
            model.value.browserLang.push({lang: 'en', url: ''});
            break;

        case 'OS':
            model.value.os.push({os: 'ios', url: ''});
            break;
    
        default:
            break;
    }
}

</script>
