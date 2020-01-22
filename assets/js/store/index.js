import Vue from 'vue';
import Vuex from 'vuex';
import SecurityModule from './security';
import FeedModule from './feed';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        feed: FeedModule,
        security: SecurityModule,
    }
});