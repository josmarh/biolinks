<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" 
                enter="ease-out duration-300" 
                enter-from="opacity-0" 
                enter-to="opacity-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100" 
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>
            <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
            <TransitionChild as="template" 
                enter="ease-out duration-300" 
                enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                enter-to="opacity-100 translate-y-0 sm:scale-100" 
                leave="ease-in duration-200" 
                leave-from="opacity-100 translate-y-0 sm:scale-100" 
                leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <DialogPanel class="relative bg-white text-left overflow-hidden shadow-xl 
                transform transition-all sm:my-8 sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-2 sm:ml-0 sm:text-left">
                            <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> {{type}} </DialogTitle>
                        </div>
                    </div>
                    <div class="mt-6">
                        <form @submit.prevent="save">
                            <div class="relative mb-4">
                                <input type="text" 
                                    id="name" 
                                    name="name"
                                    v-model="model.name"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm 
                                    text-gray-900 bg-transparent border-1 
                                    border-gray-300 appearance-none dark:text-white 
                                    dark:border-gray-600 dark:focus:border-blue-500 
                                    focus:outline-none focus:ring-0 
                                    focus:border-blue-600 peer" 
                                    placeholder=" " required="" />
                                <label for="name" 
                                    class="absolute text-sm text-gray-500 dark:text-gray-400 
                                    duration-300 transform -translate-y-4 scale-75 top-2 z-10 
                                    origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 
                                    peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                    peer-placeholder-shown:scale-100 
                                    peer-placeholder-shown:-translate-y-1/2 
                                    peer-placeholder-shown:top-1/2 peer-focus:top-2 
                                    peer-focus:scale-75 peer-focus:-translate-y-4 left-1">Name
                                </label>
                            </div>
                            <div v-if="type=='Permission'" class="relative mb-4 hidden">
                                <label for="permit-type" 
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                    Select Type
                                </label>
                                <select id="permit-type" v-model="model.type"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="menu">Menu</option>
                                    <option value="role">Role</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="mt-3 w-full inline-flex justify-center border 
                                    shadow-sm px-6 py-2 bg-blue-600 hover:bg-blue-700
                                    text-sm font-medium text-white
                                    sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Save
                                </button>
                                <button type="button" 
                                    class="mt-3 w-full inline-flex justify-center border 
                                    border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium 
                                    text-gray-700 hover:bg-gray-50  sm:mt-0 sm:ml-3 
                                    sm:w-auto sm:text-sm" 
                                    @click="open = false" ref="cancelButtonRef">Cancel
                                </button>
                            </div>
                        </form>
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
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';

const props = defineProps({
    type: String,
    action: String,
    show: Boolean,
    data: Object
})
const emit = defineEmits(['save','update','cancel'])
const open = ref(props.show)
const model = ref({
    id: props.data.id,
    name: props.data.name,
    type: props.data.hasOwnProperty('type') ? props.data.type : ''
})

watch(() => props.show, (newVal, oldVal) => {
    open.value = newVal
})
watch(open, (newVal, oldVal) => {
    if(newVal==false)
        emit('cancel')
})
watch(() => props.data, (newVal, oldVal) => {
    model.value = newVal
}, {deep: true})

function save() {
    if(props.action=='create')
        emit('save', model.value)
    else
        emit('update', model.value)
}

function cancel() {
    emit('cancel')
}
</script>

<style>

</style>