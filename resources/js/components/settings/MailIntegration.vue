<template>
    <div class="md:grid md:grid-cols-3 md:gap-6 mt-6 bg-white px-4 py-5 shadow-lg rounded">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Email Integration
                </h3>
                <p class="mt-1 text-sm text-gray-600">
                    Set-up an email integration here and your emails will directly get pushed into your ESP.
                </p>
            </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
            <div class="flex gap-1">
                <button type="button" @click="addEsp('mailchimp')"
                class="text-blue-700 border-2 
                border-blue-700 focus:ring-4 
                focus:outline-none focus:ring-blue-300 font-medium 
                text-sm px-3 py-2.5 text-center mr-2 mb-2 
                dark:border-blue-500 dark:text-blue-500 flex gap-2
                dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <img :src="helper.applink + '/temps/mailchimp.png'" alt="MailChimp" class="w-28">
                    <font-awesome-icon 
                    v-if="model.mailchimp.apikey && model.mailchimp.listid"
                    icon="fa-solid fa-circle-check" 
                    class="text-green-600" />
                </button>
                <button type="button" @click="addEsp('getresponse')"
                class="text-blue-700 border-2 
                border-blue-700 focus:ring-4 
                focus:outline-none focus:ring-blue-300 font-medium 
                text-sm px-3 py-2.5 text-center mr-2 mb-2 
                dark:border-blue-500 dark:text-blue-500 flex gap-2
                dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <img :src="helper.applink + '/temps/getresponse.png'" alt="Get Response" class="w-28">
                    <font-awesome-icon 
                    v-if="model.getresponse.apikey && model.getresponse.campaignId"
                    icon="fa-solid fa-circle-check" 
                    class="text-green-600" />
                </button>
                <button type="button" @click="addEsp('emailoctopus')"
                class="text-blue-700 border-2 
                border-blue-700 focus:ring-4 
                focus:outline-none focus:ring-blue-300 font-medium 
                text-sm px-3 py-2.5 text-center mr-2 mb-2 
                dark:border-blue-500 dark:text-blue-500 flex gap-2
                dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <img :src="helper.applink + '/temps/octopus.png'" alt="Email Octopus" class="w-28">
                    <font-awesome-icon 
                    v-if="model.emailoctopus.apikey && model.emailoctopus.listid"
                    icon="fa-solid fa-circle-check" 
                    class="text-green-600" />
                </button>
                <button type="button" @click="addEsp('converterkit')"
                class="text-blue-700 border-2 
                border-blue-700 focus:ring-4 
                focus:outline-none focus:ring-blue-300 font-medium 
                text-sm px-2 py-2.5 text-center mr-2 mb-2 
                dark:border-blue-500 dark:text-blue-500 flex gap-2
                dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <img :src="helper.applink + '/temps/convertkit.png'" alt="ConverterKit" class="w-28">
                    <font-awesome-icon 
                    v-if="model.converterkit.apikey && model.converterkit.formId"
                    icon="fa-solid fa-circle-check" 
                    class="text-green-600" />
                </button>
                
            </div>
            <div class="flex gap-1">
                <button type="button" @click="addEsp('mailerlite')"
                class="text-blue-700 border-2 
                border-blue-700 focus:ring-4 
                focus:outline-none focus:ring-blue-300 font-medium 
                text-sm px-3 py-2.5 text-center mr-2 mb-2 
                dark:border-blue-500 dark:text-blue-500 flex gap-2
                dark:hover:bg-blue-600 dark:focus:ring-blue-800">
                    <img :src="helper.applink + '/temps/mailerlite.png'" alt="mailerlite" class="w-28">
                    <font-awesome-icon 
                    v-if="model.mailerlite.apikey && model.mailerlite.groupId"
                    icon="fa-solid fa-circle-check" 
                    class="text-green-600" />
                </button>
            </div>
            <!-- mailchimp fields -->
            <div class="flex gap-4 mt-3" v-if="currentSection=='mailchimp'">
                <div class="w-full">
                    <label for="mailchimp-apikey" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Mailchimp API Key
                    </label>
                    <input type="text" id="mailchimp-apikey" 
                    v-model="model.mailchimp.apikey"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Leave Empty to disable this integration
                    </p>
                </div>
                <div class="w-full">
                    <label for="mailchimp-listid" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Mailchimp List ID
                    </label>
                    <input type="text" id="mailchimp-listid" 
                    v-model="model.mailchimp.listid"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Ensure you add the List/Audience ID
                    </p>
                </div>
            </div>
            <!-- getresponse fields -->
            <div class="flex gap-4 mt-3" v-if="currentSection=='getresponse'">
                <div class="w-full">
                    <label for="mailchimp-apikey" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        GetResponse API Key
                    </label>
                    <input type="text" id="mailchimp-apikey" 
                    v-model="model.getresponse.apikey"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Leave Empty to disable this integration
                    </p>
                </div>
                <div class="w-full">
                    <label for="getresponse-campaignId" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        GetResponse Campaign ID
                    </label>
                    <input type="text" id="getresponse-campaignId" 
                    v-model="model.getresponse.campaignId"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                </div>
            </div>
            <!-- Email Octopus -->
            <div class="flex gap-4 mt-3" v-if="currentSection=='emailoctopus'">
                <div class="w-full">
                    <label for="emailoctopus-apikey" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Email Octopus API Key
                    </label>
                    <input type="text" id="emailoctopus-apikey" 
                    v-model="model.emailoctopus.apikey"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Leave Empty to disable this integration
                    </p>
                </div>
                <div class="w-full">
                    <label for="emailoctopus-listid" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        Email Octopus List ID
                    </label>
                    <input type="text" id="emailoctopus-listid" 
                    v-model="model.emailoctopus.listid"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Ensure you add the List ID
                    </p>
                </div>
            </div>
            <!-- Converter kit -->
            <div class="flex gap-4 mt-3" v-if="currentSection=='converterkit'">
                <div class="w-full">
                    <label for="converterkit-apikey" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        ConverterKit API Key
                    </label>
                    <input type="text" id="converterkit-apikey" 
                    v-model="model.converterkit.apikey"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Leave Empty to disable this integration
                    </p>
                </div>
                <div class="w-full">
                    <label for="converterkit-formId" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        ConverterKit Form ID
                    </label>
                    <input type="text" id="converterkit-formId" 
                    v-model="model.converterkit.formId"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Ensure you add the Form ID
                    </p>
                </div>
            </div>
            <!-- Mailer lite -->
            <div class="flex gap-4 mt-3" v-if="currentSection=='mailerlite'">
                <div class="w-full">
                    <label for="mailerlite-apikey" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        MailerLite API Key
                    </label>
                    <input type="text" id="mailerlite-apikey" 
                    v-model="model.mailerlite.apikey"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Leave Empty to disable this integration
                    </p>
                </div>
                <div class="w-full">
                    <label for="mailerlite-groupId" 
                        class="block mb-2 text-sm font-medium 
                        text-gray-900 dark:text-white">
                        MailerLite Form ID
                    </label>
                    <input type="text" id="mailerlite-groupId" 
                    v-model="model.mailerlite.groupId"
                    class="bg-gray-50 border border-gray-300 
                    text-gray-900 text-sm  
                    focus:ring-blue-500 focus:border-blue-500 
                    block w-full p-2.5 dark:bg-gray-700 
                    dark:border-gray-600 dark:placeholder-gray-400 
                    dark:text-white dark:focus:ring-blue-500 
                    dark:focus:border-blue-500" 
                    placeholder="">
                    <p class="mt-1 text-gray-500 text-xs">
                        Ensure you add the Group ID
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <button type="button" @click="updateModel"
                    class="text-white bg-blue-700 hover:bg-blue-800 
                    focus:ring-0 focus:ring-blue-300 font-medium 
                    text-sm px-5 py-2.5 mr-2 capitalize
                    dark:bg-blue-600 dark:hover:bg-blue-700 
                    focus:outline-none dark:focus:ring-blue-800">
                    Update
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import helper from '../../helpers'

const props = defineProps({
    data: Object,
});
const emit = defineEmits(['updateModel']);

let model = ref(props.data);
let currentSection = ref('')

watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true});

function updateModel() {
    emit('updateModel', model.value)
}

function addEsp(type) {
    currentSection.value = type
}
</script>

<style>

</style>