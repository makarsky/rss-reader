import Vue from 'vue';
import VueRouter from 'vue-router';

import Feed from './components/Feed';
import Login from './components/Login';
import Registration from './components/Registration';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes:[
        { path: '*', redirect: '/login' },
        {path: '/login', name: 'login', component: Login},
        {path: '/registration', name: 'registration', component: Registration},
        {path: '/feed', name: 'home', component: Feed},
    ]
});

export default router;
