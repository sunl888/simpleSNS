import Vue from 'vue';
import MuseUI from 'muse-ui';
import router from './routes';
import 'animate.css/animate.min.css';
import 'muse-ui/dist/muse-ui.css';
import 'muse-ui/dist/theme-light.css';
import App from './App.vue';
Vue.use(MuseUI);
// Vue.use(Router);
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App }
});
