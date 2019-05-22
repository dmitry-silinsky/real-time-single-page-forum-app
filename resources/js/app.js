require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'
import VeeValidate from 'vee-validate'

Vue.use(Vuetify)
Vue.use(VeeValidate)

import router from './router'

import Home from './components/Home'

const app = new Vue({
    el: '#app',
    router,
    components: {
        Home
    }
});
