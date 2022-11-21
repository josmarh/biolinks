import './bootstrap';

import { createApp } from 'vue';

import app from './App.vue'
import router from './router';
import store from './store';

import '../css/index.css'
import 'flowbite'
import Notifications from 'notiwind'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

createApp(app)
    .use(router)
    .use(store)
    .use(Notifications)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount("#app")