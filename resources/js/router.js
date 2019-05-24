import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from './components/auth/Login'
import Logout from './components/auth/Logout'
import SignUp from './components/auth/SignUp'
import ForumIndex from './components/forum/Index'

const routes = [
    { path: '/login', component: Login, name: 'login' },
    { path: '/logout', component: Logout, name: 'logout' },
    { path: '/signup', component: SignUp, name: 'signUp' },
    { path: '/forum', component: ForumIndex, name: 'forum.index' }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history'
})

export default router
