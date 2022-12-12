<template>
    <Menu as="div" class="relative flex-shrink-0 ">
        <div>
            <MenuButton class="rounded-full flex items-right 
                focus:outline-none focus:ring-0 focus:ring-offset-2 focus:ring-blue">
                <span class="sr-only">Open user menu</span>
                <div class="items-center flex">
                    <button type="button" 
                        class="text-white bg-blue-700 hover:bg-blue-800 
                        focus:ring-0 focus:ring-blue-300 font-medium 
                        text-sm px-5 py-2.5 mr-2 capitalize
                        dark:bg-blue-600 dark:hover:bg-blue-700 
                        focus:outline-none dark:focus:ring-blue-800">
                        <font-awesome-icon icon="fa-solid fa-plus" />
                        Create
                    </button>
                </div>
            </MenuButton>
        </div>
        <transition
            enter-active-class="transition duration-100 ease-out transform"
            enter-from-class="opacity-0 scale-90"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-100 ease-in transform"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-90">
            <MenuItems class="overflow-hidden absolute right-0 
                mt-2 w-48 bg-white border shadow-lg z-0
                origin-top-right focus:outline-none text-gray-400">
                <MenuItem v-for="(item, i) in listOptions" :key="i"
                    v-slot="{active}">
                    <a @click="newForm(item.type)" 
                        :class="{'bg-gray-100': active}" 
                        class="block py-2 px-4 text-sm text-gray-700 
                        cursor-pointer inline-flex w-full">
                        <font-awesome-icon icon="fa-solid fa-circle-dot" class="h-4 w-4 mr-2 mt-0.5" :class="item.color" />
                        {{item.label}}
                    </a>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>

    <LeadGeneration v-if="modal.type=='lead'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Link v-if="modal.type=='link'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Fbgroup v-if="modal.type=='fbGroup'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <TextBlock v-if="modal.type=='text'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Soundcloud v-if="modal.type=='scloud'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Youtube v-if="modal.type=='ytube'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Twitch v-if="modal.type=='twitch'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Vimeo v-if="modal.type=='vimeo'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <Spotify v-if="modal.type=='spotify'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <TikTok v-if="modal.type=='tiktok'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
    <MailSignup v-if="modal.type=='mail'" :show-form="modal.showSectionModal" @close-form="closeForm"/>
</template>

<script setup>
import { ref } from 'vue';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import LeadGeneration from './biolink-section-modals/LeadGeneration.vue';
import Link from './biolink-section-modals/Link.vue'
import Fbgroup from './biolink-section-modals/Fbgroup.vue'
import TextBlock from './biolink-section-modals/TextBlock.vue'
import Soundcloud from './biolink-section-modals/Soundcloud.vue'
import Youtube from './biolink-section-modals/Youtube.vue'
import Twitch from './biolink-section-modals/Twitch.vue'
import Vimeo from './biolink-section-modals/Vimeo.vue'
import Spotify from './biolink-section-modals/Spotify.vue'
import TikTok from './biolink-section-modals/TikTok.vue';
import MailSignup from './biolink-section-modals/MailSignup.vue';

const emit = defineEmits(['reloadSettings'])
let modal = ref({
    type: '',
    showSectionModal: false,
    isDisabled: false
})

function closeForm() {
    modal.value.showSectionModal = false
    modal.value.type = '';
    emit('reloadSettings');
}

function newForm(type) {
    modal.value.showSectionModal = true
    modal.value.type = type
}

const listOptions = [
    {label: 'Lead Generation', type: 'lead', color:'text-blue-600'},
    {label: 'Link', type: 'link', color:'text-green-600'},
    {label: 'Facebook Group', type: 'fbGroup', color:'text-blue-800'},
    {label: 'Text Block', type: 'text', color:'text-black'},
    {label: 'Sound Cloud', type: 'scloud', color:'text-orange-500'},
    {label: 'YouTube', type: 'ytube', color:'text-red-500'},
    {label: 'Twitch', type: 'twitch', color:'text-[#6441A5]'},
    {label: 'Vimeo', type: 'vimeo', color:'text-[#1AB7EA]'},
    {label: 'Spotify', type: 'spotify', color:'text-[#1DB954]'},
    {label: 'Tik Tok', type: 'tiktok', color:'text-[#FD3E3E]'},
    {label: 'Mail signup', type: 'mail', color:'text-[#C91685]'},
    {label: 'WhatsApp', type: 'whatsapp', color:'text-[#1DB954]'},
    {label: 'FAQ', type: 'faq', color:'text-[#007BFF]'},
    {label: 'Google Reviews', type: 'google-review', color:'text-[#E50000]'},
    {label: 'Calendly', type: 'calendly', color:'text-[#D304E0]'},
    {label: 'HTML/Js Block', type: 'html-js-block', color:'text-[#808000]'},
    {label: 'Clubhouse', type: 'clubhouse', color:'text-blue-800'}
];
</script>

<style>

</style>