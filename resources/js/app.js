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
import { faRightFromBracket, faLink, faEnvelope, 
    faChartColumn, faPlus, faCalendar, faEllipsisVertical, 
    faPaperPlane, faPencil, faTrash, faCircleExclamation, 
    faGauge, faCircleDot, faHashtag, faCopy, faQrcode, 
    faArrowUpRightFromSquare, faEarthAfrica, faClipboardCheck, faClipboard,  
} from '@fortawesome/free-solid-svg-icons'

library.add( faRightFromBracket, faLink, faEnvelope, 
    faChartColumn, faPlus, faCalendar, faEllipsisVertical,
    faPaperPlane, faPencil, faTrash, faCircleExclamation, 
    faGauge, faCircleDot, faHashtag, faCopy, faQrcode, 
    faArrowUpRightFromSquare, faEarthAfrica, faClipboardCheck, faClipboard 
)

createApp(app)
    .use(router)
    .use(store)
    .use(Notifications)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount("#app")