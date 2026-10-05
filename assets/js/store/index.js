import { createStore } from 'vuex';
import SecurityModule from './security';
import RegistrationModule from './registration';
import FeedModule from './feed';

export default createStore({
    modules: {
        feed: FeedModule,
        security: SecurityModule,
        registration: RegistrationModule,
    }
});
