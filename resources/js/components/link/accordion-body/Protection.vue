<template>
    <div class="px-6 py-4">
        <div class="relative">
            <label for="password" 
                class="block mb-2 text-sm font-medium 
                text-gray-900 dark:text-white">
                <font-awesome-icon icon="fa-solid fa-key" />
                Password
            </label>
            <input v-model="model.password" 
            type="password" name="password" id="password" 
            class="bg-gray-50 border border-gray-300 text-gray-900 
            text-sm focus:ring-blue-500 focus:border-blue-500 
            block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 
            dark:placeholder-gray-400 dark:text-white" 
            placeholder="••••••••" required>
            <showPassword v-if="model.password !=''" :elem="'password'"/>
        </div>
        <p class="flex gap-2 text-gray-500 text-sm">
            Require users to enter a password before accessing the link.
        </p>
        <div class="mt-4">
            <label for="content-warning" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="content-warning" 
                    class="sr-only peer"
                    @change="updateContentWarning($event)"
                    :checked="model.contentWarning == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Sensitive content warning
                </span>
            </label>
            <p class="flex gap-2 text-gray-500 text-sm">
                Require users to confirm that they want to access your link and 
                letting them know that the link might be sensitive.
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import ShowPassword from '../../../components/ShowPassword.vue'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateLinkSetting']);
let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    emit('updateLinkSetting', model.value)
}, {deep: true});

function updateContentWarning(ev) {
    let checked = ev.target.checked;
    if(checked)
        model.value.contentWarning = 'yes';
    else
        model.value.contentWarning = 'no';
}
</script>

<style>

</style>