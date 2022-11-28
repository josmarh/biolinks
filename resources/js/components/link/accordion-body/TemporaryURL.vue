<template>
    <div class="px-6 py-4">
        <div>
            <label for="schedule-temp-url" 
                class="inline-flex relative items-center cursor-pointer">
                <input type="checkbox"
                    id="schedule-temp-url" 
                    class="sr-only peer"
                    @change="updateScheduleURL($event)"
                    :checked="model.scheduleSwitch == 'yes' ? true : false">
                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none 
                    peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full 
                    peer peer-checked:after:translate-x-full 
                    peer-checked:after:border-white 
                    after:content-[''] after:absolute after:top-[2px] 
                    after:left-[2px] after:bg-white after:border-gray-300 
                    after:border after:rounded-full after:h-4 after:w-4 after:transition-all 
                    peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                    Schedule
                </span>
            </label>
            <p class="flex gap-2 text-gray-500 text-sm">
                Configure the dates on which it will work.
            </p>
        </div>
        <div v-if="model.scheduleSwitch == 'yes'"
            class="mt-4 md:flex gap-4 w-full">
            <div class="w-full">
                <label for="start-date" 
                    class="block mb-2 text-sm 
                    text-gray-900 pt-2 mr-3">
                    <font-awesome-icon icon="fa-solid fa-clock" />
                    Start Date
                </label>
                <Datepicker 
                    v-model="model.scheduleStart"
                    class="border border-gray-300 
                    text-gray-900 text-sm rounded-lg
                    focus:ring-0 focus:border-blue-500 
                    block w-full"
                ></Datepicker>
            </div>
            <div class="w-full">
                <label for="end-date" 
                    class="block mb-2 text-sm 
                    text-gray-900 pt-2 mr-3">
                    <font-awesome-icon icon="fa-solid fa-clock" />
                    End Date
                </label>
                <Datepicker 
                    v-model="model.scheduleEnd"
                    class="border border-gray-300 
                    text-gray-900 text-sm rounded-lg
                    focus:ring-0 focus:border-blue-500 
                    block w-full"
                ></Datepicker>
            </div>
        </div>
        <div class="mt-4">
            <label for="click-limit" 
                class="block mb-2 text-sm font-normal flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-computer-mouse" class="mt-0.5" />
                Clicks limit
            </label>
            <input v-model="model.clickLimit"
                type="number" name="click-limit" id="click-limit" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Only allow the link to work for a certain amount of clicks.
            </p>
        </div>
        <div class="mt-4">
            <label for="redirect-url" 
                class="block mb-2 text-sm font-normal flex
                text-gray-900 dark:text-white capitalize gap-2">
                <font-awesome-icon icon="fa-solid fa-hourglass-end" class="mt-0.5" />
                Expiration URL
            </label>
            <input v-model="model.redirectURL"
                type="url" name="redirect-url" id="redirect-url" 
                class="bg-gray-50 border border-gray-300 
                text-gray-900 text-sm focus:ring-blue-500 
                focus:border-blue-500 block w-full p-2.5 
                dark:bg-gray-600 dark:border-gray-500
                dark:placeholder-gray-400 dark:text-white" 
                placeholder="">
            <p class="flex gap-2 text-gray-500 text-sm">
                Visitors will be redirected to this URL after the main link expires.
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps({
    data: Object
})
const emit = defineEmits(['updateLinkSetting']);

let model = ref(props.data)

watch(model, (newVal, oldVal) => {
    model.value.scheduleStart = dformat(model.value.scheduleStart);
    model.value.scheduleEnd = dformat(model.value.scheduleEnd);

    emit('updateLinkSetting', model.value)
}, {deep: true})

function updateScheduleURL(ev) {
    let checked = ev.target.checked;
    if(checked)
        model.value.scheduleSwitch = 'yes';
    else
        model.value.scheduleSwitch = 'no';
}

function dformat(date) {
    let d = new Date(date);
    const day = d.getDate() <= 9 == 1 ? `0${d.getDate()}` : d.getDate();
    const month = d.getMonth()+1  <= 9 == 1 ? `0${d.getMonth()+1}` : d.getMonth()+1;
    const year = d.getFullYear();
    const time = d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
    return `${year}-${month}-${day} ${time}`;
}
</script>

<style>

</style>