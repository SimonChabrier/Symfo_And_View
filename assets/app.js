/*
 * Fichier principal de l'application Vue.js
 * il est inclus dans le fichier base.html.twig comme recommandé avec webpack.
 * (and its CSS file) in your base layout (base.html.twig).
 */

// import des styles
import "@styles/reset.css";

// start the Stimulus application (non utilisé pour le moment)
// import './bootstrap';

// initialisation de Vue et de l'application
import { createApp } from "vue";

import App from "@root/App.vue";

import router from "@app/router/router";
import store from "@app/store/store";

// monter App sur l'élément #vue-app dans le fichier base.html.twig
createApp(App)
    .use(store)
    .use(router)
    .mount("#app");




