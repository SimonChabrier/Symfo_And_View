/*
 * Fichier principal de l'application
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// import des styles
import '@styles/app.css';
import '@styles/reset.css';

// start the Stimulus application (non utilisé pour le moment)
// import './bootstrap';

// initialisation de Vue et de l'application
import { createApp } from 'vue'

import App from '@root/App.vue';

import router from '@app/router'
import store from '@app/store'

// monter App sur l'élément #vue-app dans le fichier base.html.twig
createApp(App)
    .use(store)
    .use(router)
    .mount('#app')




