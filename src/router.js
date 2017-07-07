import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router);

import Login from './views/Login.vue'
import Home from './views/Home.vue'
const router = new Router({
    mode: 'history',
    routes: [
        { path: '/', component: Login },
        { path: '/index.html', component: Login },
    ]
});
export default router;