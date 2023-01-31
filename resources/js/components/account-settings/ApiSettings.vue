<template>
    <div class="p-6 max-w-full bg-white 
       border border-gray-200 
       shadow-md dark:bg-gray-800">
       <h5 class="mb-2 text-xl font-semibold 
           tracking-tight text-gray-900">
           Api Settings
       </h5>
       <p class="mb-3 font-normal text-gray-500 dark:text-gray-400">
        Please Enter your Google API key here. 
       </p>
       <form v-on:submit.prevent="updateApiKey">
           <div class="relative w-full mb-3">
               <label
                   class="block uppercase text-gray-700 text-xs font-bold mb-2"
                   for="grid-password">
                   Api Key
               </label>
               <input
                   v-model="model.key"
                   name="key"
                   data-validation-required-message="The API Key is required"
                   class="border-0 px-3 py-3 placeholder-gray-400 
                   text-gray-700 bg-white rounded text-sm shadow 
                   focus:outline-none focus:ring w-full"
                   placeholder="Your Google API Key"
                   style="transition: all 0.15s ease 0s;"
                   type="password"
                   required/>
           </div>
        
           <div class="text-center mt-6">
               <button
                   class="bg-blue-600 text-white active:bg-blue-700 
                   text-sm font-bold uppercase px-6 py-3 rounded 
                   shadow hover:shadow-lg outline-none focus:outline-none 
                   mr-1 mb-1 w-full relative flex justify-center"
                   type="submit"
                   style="transition: all 0.15s ease 0s;"
                   :disabled="btnDisable">
                   Save
                   <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                       <ButtonSpinner v-if="btnDisable==true"/>
                   </span>
               </button>
           </div>
       </form>
   </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import ButtonSpinner from '../ButtonSpinner.vue';

const props = defineProps({
   data: Object,
   btnDisable: Boolean
});

const api_key = "";

const emit = defineEmits(['update'])

let model = ref(props.data);

function updateApiKey() {
   emit('update', model.value, 'key');
}
</script>

<style>

</style>