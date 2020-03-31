/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// console.log(files)

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('Form', require('./components/Form.vue'));

import admin 				from './components/admin/index.vue'
import smtp 				from './components/admin/smtp.vue'
import jobs 				from './components/admin/jobs.vue'
import adminhelp			from './components/admin/help.vue'
import adminprofile 		from './components/admin/profile.vue'
import adminnotifications 	from './components/admin/notifications.vue'
import adminleftnav 		from './components/admin/leftnav.vue'

import user 				from './components/user/index.vue'
import userhelp				from './components/user/help.vue'
import userprofile 			from './components/user/profile.vue'
import usernotifications 	from './components/user/notifications.vue'
import userleftnav 			from './components/user/leftnav.vue'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue'
import VueProgressBar from 'vue-progressbar'
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Install BootstrapVue
// Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)
const options = {
  color: '#7aa9cc',
  failedColor: 'red',
  thickness: '3px',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.use(VueProgressBar, options)

const app = new Vue({
    el: '#app',
    components: {
    	admin,
    	smtp,
    	jobs,
  		adminhelp,
  		adminprofile,
  		adminnotifications,
  		adminleftnav,
  		user,
  		userhelp,
  		userprofile,
  		usernotifications,
  		userleftnav
    }
});
