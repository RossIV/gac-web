/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('team-registration', require('./components/TeamRegistration.vue').default);
Vue.component('user-dashboard', require('./components/UserDashboard.vue').default);
Vue.component('user-profile', require('./components/UserProfile.vue').default);
Vue.component('my-team', require('./components/MyTeam.vue').default);
Vue.component('login', require('./components/Login.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { Model } from 'vue-api-query'
Model.$http = axios

import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)

import * as Sentry from "@sentry/vue";
import { BrowserTracing } from "@sentry/tracing";
Sentry.init({
    Vue,
    dsn: "https://65e3aaba48f94469bef27a162846da1a@o1159398.ingest.sentry.io/6243219",
    integrations: [
        new BrowserTracing({
            tracingOrigins: ["localhost", "app.getaclue.tech", /^\//],
        }),
    ],
    // Set tracesSampleRate to 1.0 to capture 100%
    // of transactions for performance monitoring.
    // We recommend adjusting this value in production
    tracesSampleRate: 1.0,
});

const app = new Vue({
    el: '#app',
});
