
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Vuex = require('vuex');
//Vue.use(Vuex);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));
Vue.component('test1', require('./components/Test.vue'));
Vue.component('study-session', require('./components/StudySession.vue'));
Vue.component('word-question', require('./components/WordQuestion.vue'));
import store from './vuex/store';
import RandomGeneratorPlugin from './plugins/RandomGeneratorPlugin.js';
import FactPriorityPlugin from './plugins/FactPriorityPlugin.js';
Vue.use(RandomGeneratorPlugin);
Vue.use(FactPriorityPlugin);
//console.log('did something');

const app = new Vue({
    el: '#app',
    store: store
});
