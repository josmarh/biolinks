<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-20" @close="open = false">
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
                                    <DialogTitle as="h3" 
                                        class="text-lg leading-6 font-medium text-gray-900"> 
                                        {{action=='create' ? 'New User' : 'Update User'}} 
                                    </DialogTitle>
                                </div>
                            </div>
                            <div class="mt-6">
                                <form @submit.prevent="save">
                                    <div v-for="form in formField" :key="form.id"
                                        class="relative mb-4">
                                        <input :type="form.type" 
                                            :id="form.id"
                                            v-model="form.value"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm 
                                            text-gray-900 bg-transparent rounded-lg border-1 
                                            border-gray-300 appearance-none dark:text-white 
                                            dark:border-gray-600 dark:focus:border-blue-500 
                                            focus:outline-none focus:ring-0 
                                            focus:border-blue-600 peer" 
                                            placeholder=" " :required="form.required"/>
                                        <showPassword 
                                            v-if="form.type=='password' && form.value !=''" 
                                            :elem="form.id"
                                        />
                                        <label for="name" 
                                            class="absolute text-sm text-gray-500 dark:text-gray-400 
                                            duration-300 transform -translate-y-4 scale-75 top-2 z-10 
                                            origin-[0] bg-white dark:bg-gray-800 px-2 peer-focus:px-2 
                                            peer-focus:text-blue-600 peer-focus:dark:text-blue-500 
                                            peer-placeholder-shown:scale-100 
                                            peer-placeholder-shown:-translate-y-1/2 
                                            peer-placeholder-shown:top-1/2 peer-focus:top-2 
                                            peer-focus:scale-75 peer-focus:-translate-y-4 left-1 capitalize">
                                            {{form.label}}
                                        </label>
                                    </div>
                                    <div class="mb-4">
                                        <label for="roles" 
                                            class="block mb-2 text-sm font-medium text-gray-900 sr-only">
                                            Select an option
                                        </label>
                                        <select id="roles" v-model="model.role"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 
                                            text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 
                                            block w-full p-2.5" required>
                                        <option selected disabled hidden value="">Choose role</option>
                                        <option v-for="role in roles.data" :key="role.id" 
                                            :value="role.id">{{role.name}}</option>
                                        </select>
                                    </div>
                                    
                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                            class="mt-3 w-full inline-flex justify-center border 
                                            shadow-sm px-6 py-2 bg-indigo-600 hover:bg-indigo-700
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
import { ref, watch, computed, onMounted } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import ShowPassword from '../ShowPassword.vue';
import helpers from '../../helpers';
import adminStore from '../../store/admin-store';
import resellerStore from '../../store/reseller-store';

const props = defineProps({
    action: String,
    show: Boolean,
    data: Object,
    useType: String
});
const emit = defineEmits(['save','update','cancel']);
const roles = computed(() => adminStore.state.authGuard);
const open = ref(props.show)
const formField = ref([
    {type:'text', id:'name', value: props.data.name, label:'name', required: true},
    {type:'email', id:'email', value: props.data.email, label:'email', required: true},
    {type:'password', id:'password', value: props.data.password, label:'password', required: false},
    {type:'password', id:'password_confirmation', value: props.data.password_confirmation, label:'confirm password', required: false}
])
const model = ref({
    id: props.data.id,
    role: props.data.role,
    old_role: props.data.old_role
})

watch(() => props.show, (newVal, oldVal) => {
    open.value = newVal
})
watch(open, (newVal, oldVal) => {
    if(newVal==false)
        emit('cancel')
})
watch(() => props.data, (newVal, oldVal) => {
    model.value.id = newVal.id;
    model.value.role = newVal.role
    formField.value[0].value = newVal.name
    formField.value[1].value = newVal.email
    formField.value[2].value = newVal.password
    formField.value[3].value = newVal.password_confirmation
}, {deep: true})

function save() {
    if(props.action=='create')
        emit('save', model.value, formField.value)
    else
        emit('update', model.value, formField.value)
}

function checkAction(action) {
    if(action=='create')
        return true;
    else
        return false;
}

onMounted(() => {
    helpers.getRoles();
    resellerStore.dispatch('getRoles')
})
</script>

<style>

</style>