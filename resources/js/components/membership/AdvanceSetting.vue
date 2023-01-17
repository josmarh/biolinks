<template>
    <Modal :size="size" v-if="isShowModal" @close="closeModal">
        <template #header>
            <div class="flex items-center text-lg font-bold">
                Advance Settings
            </div>
        </template>
        <template #body>
            <Accordion flush>
                <accordion-panel>
                    <accordion-header>Main Settings</accordion-header>
                    <accordion-content>
                        <div>
                            <div class="">
                                <label for="title" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                    Title Of Your Membership / Blog
                                </label>
                                <input type="text" id="title" 
                                v-model="settings.title"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm 
                                focus:ring-blue-500 focus:border-blue-500 
                                block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500" 
                                placeholder="" required>
                            </div>
                            <div class="mt-4">
                                <label for="subHeading" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                    Subtitle
                                </label>                                                                                                                                
                                <input type="text" id="subHeading" 
                                v-model="settings.subHeading"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm 
                                focus:ring-blue-500 focus:border-blue-500 
                                block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500" 
                                placeholder="" required>
                            </div>
                            <div class="mt-4">
                                <label for="urlPath" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                    What URL path do you want to use?
                                </label>
                                <select id="urlPath" 
                                v-model="settings.mainSetting.urlPath"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm  
                                focus:ring-blue-500 focus:border-blue-500 
                                block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500">
                                    <option value="members">/members</option>
                                    <option value="blog">/blog</option>
                                </select>
                            </div>
                            <div class="mt-4">
                                <label for="imgUrl" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                    Share Image
                                </label>                                                                                                                                
                                <input type="url" id="imgUrl" 
                                v-model="settings.mainSetting.imgUrl"
                                class="bg-gray-50 border border-gray-300 
                                text-gray-900 text-sm 
                                focus:ring-blue-500 focus:border-blue-500 
                                block w-full p-2.5 dark:bg-gray-700 
                                dark:border-gray-600 dark:placeholder-gray-400 
                                dark:text-white dark:focus:ring-blue-500 
                                dark:focus:border-blue-500" 
                                placeholder="https:// (Type in image URL)" required>
                            </div>
                            <div class="mt-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="yes" class="sr-only peer"
                                    :checked="settings.mainSetting.showSubLoginBar=='yes' ? true : false"
                                    @change="toogleChecked($event, 'showSubLoginBar')">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                                    peer-focus:ring-4 peer-focus:ring-blue-300 
                                    dark:peer-focus:ring-blue-800 rounded-full 
                                    peer dark:bg-gray-700 peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute 
                                    after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 
                                    after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                                    dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Show (Top) Subscribe / Login Bar?
                                    </span>
                                </label>
                                <p class="mt-1 text-sm text-gray-600">
                                    If you're not planning to sell memberships, 
                                    it's preferable to turn this feature off.
                                </p>
                            </div>
                            <div class="mt-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="yes" class="sr-only peer"
                                    :checked="settings.mainSetting.showTotalSubscribers=='yes' ? true : false"
                                    @change="toogleChecked($event, 'showTotalSubscribers')">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none 
                                    peer-focus:ring-4 peer-focus:ring-blue-300 
                                    dark:peer-focus:ring-blue-800 rounded-full 
                                    peer dark:bg-gray-700 peer-checked:after:translate-x-full 
                                    peer-checked:after:border-white after:content-[''] after:absolute 
                                    after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 
                                    after:border after:rounded-full after:h-5 after:w-5 after:transition-all 
                                    dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                        Show How Many Subscribers You Have?
                                    </span>
                                </label>
                            </div>
                            <div class="mt-4 ml-4">
                                <label class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                    <font-awesome-icon icon="fa-solid fa-turn-down" class="mr-2"/>
                                    What Do You Want To Call Your Members?
                                </label>
                                <p class="mt-1 text-sm text-gray-600">
                                    <font-awesome-icon icon="fa-solid fa-hand-point-right" class="mr-2"/>
                                    Here you can set-up a nickname for your 
                                    members if you have one. For example: "Beliebers"
                                </p>
                                <div class="grid grid-cols-12 gap-4 mt-4">
                                    <div class="col-span-6">
                                        <label for="memberNickName" 
                                            class="block mb-2 text-sm font-medium 
                                            text-gray-900 dark:text-white">
                                            Member Nickname
                                        </label>                                                                                                                                
                                        <input type="text" id="memberNickName" 
                                        v-model="settings.mainSetting.memberNickName"
                                        class="bg-gray-50 border border-gray-300 
                                        text-gray-900 text-sm 
                                        focus:ring-blue-500 focus:border-blue-500 
                                        block w-full p-2.5 dark:bg-gray-700 
                                        dark:border-gray-600 dark:placeholder-gray-400 
                                        dark:text-white dark:focus:ring-blue-500 
                                        dark:focus:border-blue-500" 
                                        placeholder="member" required>
                                    </div>
                                    <div class="col-span-6">
                                        <label for="memberNickNamePlural" 
                                            class="block mb-2 text-sm font-medium 
                                            text-gray-900 dark:text-white">
                                            Member Nickname Plural
                                        </label>                                                                                                                                
                                        <input type="text" id="memberNickNamePlural" 
                                        v-model="settings.mainSetting.memberNickNamePlural"
                                        class="bg-gray-50 border border-gray-300 
                                        text-gray-900 text-sm 
                                        focus:ring-blue-500 focus:border-blue-500 
                                        block w-full p-2.5 dark:bg-gray-700 
                                        dark:border-gray-600 dark:placeholder-gray-400 
                                        dark:text-white dark:focus:ring-blue-500 
                                        dark:focus:border-blue-500" 
                                        placeholder="members" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </accordion-content>
                </accordion-panel>
                <accordion-panel>
                    <accordion-header>Social Media Settings</accordion-header>
                    <accordion-content>
                        <div>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="facebook" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        Facebook
                                    </label>
                                    <input type="text" id="facebook" 
                                    v-model="settings.smedia.facebook"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Username without @" required>
                                </div>
                                <div>
                                    <label for="twitter" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        Twitter
                                    </label>
                                    <input type="text" id="twitter" 
                                    v-model="settings.smedia.twitter"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Username without @" required>
                                </div>
                            </div>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="instagram" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        Instagram
                                    </label>
                                    <input type="text" id="instagram" 
                                    v-model="settings.smedia.instgram"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Username without @" required>
                                </div>
                                <div>
                                    <label for="pinterest" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        Pinterest
                                    </label>
                                    <input type="text" id="pinterest" 
                                    v-model="settings.smedia.pinterest"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Username without @" required>
                                </div>
                            </div>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="youtube" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        Youtube
                                    </label>
                                    <input type="text" id="youtube" 
                                    v-model="settings.smedia.youtube"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Full Youtube URL - https://" required>
                                </div>
                                <div>
                                    <label for="linkedin" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        LinkedIn
                                    </label>
                                    <input type="text" id="linkedin" 
                                    v-model="settings.smedia.linkedin"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Full LinkedIn URL - https://" required>
                                </div>
                            </div>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div class="">
                                    <label for="tiktok" 
                                    class="block mb-2 text-sm font-medium 
                                    text-gray-900 dark:text-white">
                                        TikTok
                                    </label>
                                    <input type="text" id="tiktok" 
                                    v-model="settings.smedia.tiktok"
                                    class="bg-gray-50 border border-gray-300 
                                    text-gray-900 text-sm 
                                    focus:ring-blue-500 focus:border-blue-500 
                                    block w-full p-2.5 dark:bg-gray-700 
                                    dark:border-gray-600 dark:placeholder-gray-400 
                                    dark:text-white dark:focus:ring-blue-500 
                                    dark:focus:border-blue-500" 
                                    placeholder="Username without @" required>
                                </div>
                            </div>
                        </div>
                    </accordion-content>
                </accordion-panel>
            </Accordion>
        </template>
        <template #footer>
            <div class="flex justify-between">
                <button @click="closeModal" type="button" 
                class="text-gray-500 bg-white hover:bg-gray-100 
                focus:ring-4 focus:outline-none focus:ring-blue-300 
                border border-gray-200 text-sm font-medium px-5 py-2.5 
                hover:text-gray-900 focus:z-10 dark:bg-gray-700 
                dark:text-gray-300 dark:border-gray-500 dark:hover:text-white 
                dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                    Close
                </button>
                <button @click="updateBlogSetting" type="button" 
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-0 
                focus:outline-none focus:ring-blue-300 font-medium text-sm 
                px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 
                dark:focus:ring-blue-800">
                    Update Settings
                </button>
            </div>
        </template>
    </Modal>
</template>

<script setup>
import { Modal, Accordion, AccordionPanel, AccordionHeader, AccordionContent } from 'flowbite-vue'
import { ref, watch } from 'vue'

const props = defineProps({
    showModal: Boolean,
    data: Object
})
const emit = defineEmits(['updateModal','updateModel'])
const isShowModal = ref(props.showModal)
let settings = ref(props.data)

watch(() => props.showModal, (newVal, oldVal) => {
    isShowModal.value = newVal
})
watch(() => props.data, (newVal, oldVal) => {
    settings.value = newVal
}, {deep:true})

function closeModal() {
    isShowModal.value = false
    emit('updateModal')
}

function updateBlogSetting() {
    emit('updateModel', settings.value)
}

function toogleChecked(ev, type) {
    let checked = ev.target.checked;
    if(checked && type == 'showSubLoginBar')
        settings.value.mainSetting.showSubLoginBar = 'yes'
    else if(!checked && type == 'showSubLoginBar')
        settings.value.mainSetting.showSubLoginBar = 'no'
    else if(checked && type == 'showTotalSubscribers')
        settings.value.mainSetting.showTotalSubscribers = 'yes'
    else
        settings.value.mainSetting.showTotalSubscribers = 'no'
}
</script>