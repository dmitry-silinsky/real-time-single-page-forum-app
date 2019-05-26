import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Login from './components/auth/Login'
import Logout from './components/auth/Logout'
import SignUp from './components/auth/SignUp'
import ForumIndex from './components/forum/Index'
import ForumRead from './components/forum/Read'
import CreateQuestion from './components/forum/Create'
import Category from './components/forum/Category'

const routes = [
    { path: '/login', component: Login, name: 'login', meta: { auth: false } },
    { path: '/logout', component: Logout, name: 'logout', meta: { auth: true } },
    { path: '/signup', component: SignUp, name: 'signUp', meta: { auth: false } },
    { path: '/forum', component: ForumIndex, name: 'forum.index', meta: { auth: true } },
    { path: '/question/:slug', component: ForumRead, name: 'forum.read', meta: { auth: true } },
    { path: '/ask', component: CreateQuestion, name: 'forum.ask', meta: { auth: true } },
    { path: '/category', component: Category, name: 'forum.category', meta: { auth: true } }
]

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: 'history'
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.auth)) {
        if (! User.loggedIn()) {
            next({ path: '/login' })
        } else {
            next()
        }
    } else {
        next()
    }
})

export default router
