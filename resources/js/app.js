require('./bootstrap');

import Vue from 'vue'
import Vuetify from 'vuetify'

Vue.use(Vuetify)

import router from './router'

import Home from './components/Home'

const app = new Vue({
    el: '#app',
    router,
    components: {
        Home
    }
});
