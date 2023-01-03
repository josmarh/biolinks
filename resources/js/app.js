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
    faArrowUpRightFromSquare, faEarthAfrica, faClipboardCheck, 
    faClipboard, faX, faClock, faComputerMouse, faHourglassEnd, 
    faUserShield, faKey, faBullseye, faCamera, faEye, faHeading, 
    faPaintBrush, faPalette, faPenNib, faShuffle, faParagraph, 
    faPhone, faSignature, faBell, faCircleQuestion, faCalendarDays, 
    faCode, faBars, faUser, faCircleUser, faWrench, faScroll, faHouse, 
    faPenToSquare, faGears, faList, faFileCsv, faUsers,  
} from '@fortawesome/free-solid-svg-icons'

library.add( faRightFromBracket, faLink, faEnvelope, 
    faChartColumn, faPlus, faCalendar, faEllipsisVertical,
    faPaperPlane, faPencil, faTrash, faCircleExclamation, 
    faGauge, faCircleDot, faHashtag, faCopy, faQrcode, 
    faArrowUpRightFromSquare, faEarthAfrica, faClipboardCheck, 
    faClipboard, faX, faClock, faComputerMouse, faHourglassEnd, 
    faUserShield, faKey, faBullseye, faCamera, faEye, faHeading, 
    faPaintBrush, faPalette, faPenNib, faShuffle, faParagraph, 
    faPhone, faSignature, faBell, faCircleQuestion, faCalendarDays, 
    faCode, faBars, faUser, faCircleUser, faWrench, faScroll, faHouse, 
    faPenToSquare, faGears, faList, faFileCsv, faUsers
    
)

createApp(app)
    .use(router)
    .use(store)
    .use(Notifications)
    .component('font-awesome-icon', FontAwesomeIcon)
    .mount("#app")