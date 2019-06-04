require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'
import VeeValidate from 'vee-validate'
import VueSimplemde from 'vue-simplemde'
import md from 'marked'

Vue.use(Vuetify)
Vue.use(VeeValidate)
Vue.use(VueSimplemde)

import User from './helpers/User'
import Exception from './helpers/Exception'

window.User = User
window.Exception = Exception
window.EventBus = new Vue()
window.md = md

import router from './router'

import Home from './components/Home'

const app = new Vue({
    el: '#app',
    router,
    components: {
        Home
    }
});
