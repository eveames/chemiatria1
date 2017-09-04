
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
Vue.component('fact-question', require('./components/FactQuestion.vue'));
Vue.component('skill-question', require('./components/SkillQuestion.vue'));
Vue.component('polyatomic-ion-question', require('./components/PolyatomicIonQuestion.vue'));
Vue.component('element-symbol-question', require('./components/ElementSymbolQuestion.vue'));
Vue.component('element-charge-question', require('./components/ElementChargeQuestion.vue'));
Vue.component('element-group-question', require('./components/ElementGroupQuestion.vue'));
Vue.component('sigfig-question', require('./components/SigfigQuestion.vue'));
Vue.component('ionic-formula-question', require('./components/IonicFormulaQuestion'));
Vue.component('bug-report', require('./components/BugReport.vue'));
Vue.component('frustration-report', require('./components/FrustrationReport.vue'));
Vue.component('suggestion-box', require('./components/SuggestionBox.vue'));
import store from './vuex/store';
import RandomGeneratorPlugin from './plugins/RandomGeneratorPlugin.js';
import FactPriorityPlugin from './plugins/FactPriorityPlugin.js';
import SkillPriorityPlugin from './plugins/SkillPriorityPlugin.js';
Vue.use(RandomGeneratorPlugin);
Vue.use(FactPriorityPlugin);
Vue.use(SkillPriorityPlugin);
//console.log('did something');
Vue.filter('formatFormula', function(value) {
  let str = String(value);
  let escapeRE = /\/|&|<|>|'|"/;
  if (escapeRE.test(str)) return "Please enter a correctly formatted formula (see example)";
  else {
    str = str.replace(/([\w)\]])(\d)/g, '$1<sub>$2</sub>');
    str = str.replace(/([+])(\d+)/, '<sup>$2$1</sup>');
    str = str.replace(/([-])(\d+)/, '<sup>$2&minus;</sup>');
    str = str.replace(/(<sup>)(1)([+&])/, '$1$3');
    return str;
  }
});
Vue.filter('chargeFormat', function(value) {
  let plus = value > 0;
  let str = String(value);
  if (plus) str = '+' + str;
  return str;
});
Vue.directive('focus', {
  // When the bound element is inserted into the DOM...
  inserted: function (el) {
    // Focus the element
    el.focus()
  }
});


const app = new Vue({
    el: '#app',
    store: store,
});
