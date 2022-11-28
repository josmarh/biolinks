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
                    <link-accordion title="Temporary URL" icon="fa-solid fa-clock">
                        <TemporaryURL @update-link-setting="updateTempURL" />
                    </link-accordion>

                    <link-accordion title="Protection" icon="fa-solid fa-user-shield" class="mt-4">
                        <protection @update-link-setting="updateProtection" />
                    </link-accordion>

                    <link-accordion title="Targeting" icon="fa-solid fa-bullseye" class="mt-4">
                        <target @update-link-setting="updateTarget" />
                    </link-accordion>
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
import { ref } from 'vue';
import LinkAccordion from './LinkAccordion.vue'
import TemporaryURL from './accordion-body/TemporaryURL.vue'
import Protection from './accordion-body/Protection.vue';
import Target from './accordion-body/Target.vue'

const props = defineProps({
    data: Object
})

let applink = `${window.location.protocol}//${window.location.host}/`;
let model = ref(props.data)
let linkSettings = ref({
    tempURL: {},
    protection: {},
    target: {}
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

function updateLinkSettings() {

}
</script>

<style>

</style>