import axios from 'axios';
import VueAxios from 'vue-axios';
import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import App from './App.vue';
import router from './Routes/routes';
import Vuex from './store/modules/currentUser';

// import { provideEventBus } from './Constants/EventBus';
import Snackbar from "./Components/pages/Snackbar";
import WOW from 'wow.js';
import 'animate.css';

import $ from 'jquery';
import 'jquery-ui/ui/widgets/datepicker';
import 'jquery-ui/themes/base/all.css';
import 'bootstrap/dist/css/bootstrap.css';
import './bootstrap'
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '97fde42844b93bd5ed80',
    cluster: 'ap2',
    forceTLS: true,
});
const wow = new WOW({
    boxClass: 'wow', // Default class name for animation
    animateClass: 'animated', // Default class name for animated elements
    offset: 0, // Offset to trigger the animation (in pixels)
    mobile: true, // Enable animations on mobile devices
    live: true, // Continuously check for new elements on the page
}).init();
const app = createApp(App);
// const wow = new WOW().init(); // Initialize WOW
//
// app.directive('wow', {
//     mounted(el) {
//         wow.add(el);
//         wow.sync();
//     },
//     unmounted(el) {
//         wow.remove(el);
//     },
// });

// provideEventBus(); // Uncomment this line if you want to use the event bus

app.use(VueAxios, axios);
app.use(router);
app.use(Vuex);
// app.component('Snackbar', Snackbar);
const vuetify = createVuetify({
    components,
    directives,
});

// Automatically register Vue components
const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => {
    const name = key.split('/').pop().split('.')[0];
    app.component(name, files(key).default);
});

app.use(vuetify).mount('#app');
