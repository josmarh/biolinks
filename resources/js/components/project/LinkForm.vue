<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative transform overflow-hidden bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 px-4 w-full sm:text-left">
                            <DialogTitle as="h3" 
                                class="text-lg font-medium leading-6 text-gray-900 capitalize
                                flex gap-3">
                                Create a New Link
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Easily shorten the links that you want. 
                                    More settings are available after the creation of the link.
                                </p>
                                <div class="mt-4">
                                    <form @submit.prevent="createLink">
                                        <div class="mb-4">
                                            <label for="longUrl" 
                                                class="block mb-2 text-sm font-normal flex
                                                text-gray-900 dark:text-white capitalize gap-2">
                                                <font-awesome-icon icon="fa-solid fa-arrow-up-right-from-square" class="mt-0.5" />
                                                Long Url
                                            </label>
                                            <input v-model="model.longUrl"
                                                type="url" name="longUrl" id="longUrl" 
                                                class="bg-gray-50 border border-gray-300 
                                                text-gray-900 text-sm focus:ring-blue-500 
                                                focus:border-blue-500 block w-full p-2.5 
                                                dark:bg-gray-600 dark:border-gray-500 
                                                dark:placeholder-gray-400 dark:text-white" 
                                                :placeholder="applink + 'long-url/demo'" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="shortUrl" 
                                                class="block mb-2 text-sm font-normal flex
                                                text-gray-900 dark:text-white capitalize gap-2">
                                                <font-awesome-icon icon="fa-solid fa-link" class="mt-0.5" />
                                                Short Url
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 flex 
                                                    items-center pl-3 pointer-events-none text-sm">
                                                    {{applink}}
                                                </div>
                                                <input v-model="model.linkId"
                                                type="text" name="shortUrl" id="shortUrl" 
                                                class="bg-gray-50 border border-gray-300 
                                                text-gray-900 text-sm focus:ring-blue-500 
                                                focus:border-blue-500 block w-full p-2.5 
                                                dark:bg-gray-600 dark:border-gray-500 pl-40
                                                dark:placeholder-gray-400 dark:text-white" 
                                                placeholder="randomly generated alias">
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-500">
                                            Leave empty for a random generated one.
                                        </p>
                                        <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                                            <button type="submit" 
                                                class="inline-flex w-full justify-center 
                                                border border-transparent bg-blue-600 px-4 py-2 text-base 
                                                font-medium text-white shadow-sm hover:bg-blue-700 
                                                focus:outline-none focus:ring-0 focus:ring-blue-500 
                                                focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm" 
                                                :disabled="isDisabled">
                                                Shorten Url
                                                <button-spinner v-if="isDisabled" class="pl-2"/>
                                            </button>
                                            <button type="button" 
                                                class="mt-3 inline-flex w-full justify-center 
                                                border border-gray-300 bg-white px-4 
                                                py-2 text-base font-medium text-gray-700 shadow-sm 
                                                hover:bg-gray-50 focus:outline-none focus:ring-0 
                                                focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 
                                                sm:ml-3 sm:w-auto sm:text-sm" 
                                                @click="open = false" ref="cancelButtonRef">
                                                Cancel
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </DialogPanel>
            </TransitionChild>
            </div>
        </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router';
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { notify } from 'notiwind';
import ButtonSpinner from '../ButtonSpinner.vue';
import projectlinks from '../../store/projectlinks'
import linkDefaultSettings from '../../includes/link-default-settings'

const route = useRoute();
const router = useRouter();
const props = defineProps({
    showForm: Boolean,
    data: Object
});
const emit = defineEmits(['closeForm'])
const open = ref(props.showForm)
let applink = `${window.location.protocol}//${window.location.host}/`

let model = ref({
    projectId: route.params.id,
    type: 'link',
    longUrl: null,
    linkId: null
})
let isDisabled = ref(false)

watch(() => props.showForm, (newVal, oldVal) => {
    open.value = newVal
})

watch(open, (newVal, oldVal) => {
    if(!newVal)
        emit('closeForm')
})

function createLink() {
    isDisabled.value = true;
    projectlinks
        .dispatch('storeLink', {
            link: model.value,
            linkSettings: JSON.stringify(linkDefaultSettings)
        })
        .then((res) => {
            open.value = false;
            emit('closeForm');
            isDisabled.value = false;
            
            model.value.linkId = null;
            model.value.longUrl = null

            notify({
                group: "success",
                title: "Success",
                text: res.message
            }, 4000);

            projectlinks.dispatch('getLinks', route.params.id);
           
            setTimeout(() => {
                router.push({
                    name: 'Link',
                    params: {
                        id: res.link.id
                    }
                });
            }, 1500);
        })
        .catch((err) => {
            open.value = false
            emit('closeForm');
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