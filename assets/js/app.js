import { createApp } from 'vue';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import App from './views/App.vue';
import router from './routes.js';
import store from './store';

const root = document.getElementById('app');
const isAuthenticated = JSON.parse(root.dataset.isAuthenticated);
const user = JSON.parse(root.dataset.user);

store.dispatch('security/onRefresh', { isAuthenticated, user });

const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: { mdi },
    },
});

const app = createApp(App);
app.use(store);
app.use(router);
app.use(vuetify);
app.mount('#app');

export default app;
