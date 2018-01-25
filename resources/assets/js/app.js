import Vue from 'vue';
import Vuex from 'vuex';
import MuseUI from 'muse-ui';
import router from './routes';
import 'animate.css/animate.min.css';
import tHttp from './utils/tHttp';
import 'muse-ui/dist/muse-ui.css';
import 'muse-ui/dist/theme-light.css';
import App from './App.vue';
import { getBaseUrl } from './utils/utils';
import store from './vuex/store';
import alert from './components/AlertTool';
Vue.use(MuseUI);
// Vue.use(Router);
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

let baseUrl = getBaseUrl();
window.Vue = require('vue');

Vue.use(tHttp, {
  baseURL: baseUrl + 'api/',
  router
});

Vue.prototype.$alert = alert;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));
Vue.use(Vuex);
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
});
