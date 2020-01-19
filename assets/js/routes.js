import Vue from 'vue';
import VueRouter from 'vue-router';
import store from './store';
import Feed from './components/Feed';
import Login from './components/Login';
import Registration from './components/Registration';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {path: '*', redirect: '/login'},
        {path: '/login', name: 'login', component: Login},
        {path: '/registration', name: 'registration', component: Registration},
        {path: '/feed', name: 'feed', component: Feed, meta: {requiresAuth: true}},
    ]
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters['security/isAuthenticated']) {
            next();
        } else {
            next({
                path: '/login',
                query: {redirect: to.fullPath}
            });
        }
    } else {
        next();
    }
});

export default router;
