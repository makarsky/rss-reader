import FeedAPI from '../api/feed';

const FETCHING_FEED = 'FETCHING_FEED',
    FETCHING_FEED_SUCCESS = 'FETCHING_FEED_SUCCESS',
    FETCHING_FEED_ERROR = 'FETCHING_FEED_ERROR';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
        feed: null,
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        feed(state) {
            return state.feed;
        }
    },
    mutations: {
        [FETCHING_FEED](state) {
            state.isLoading = true;
            state.error = null;
            state.feed = [];
        },
        [FETCHING_FEED_SUCCESS](state, feed) {
            state.isLoading = false;
            state.error = null;
            state.feed = feed;
        },
        [FETCHING_FEED_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.feed = [];
        }
    },
    actions: {
        async load({ commit }) {
            commit(FETCHING_FEED);
            try {
                let response = await FeedAPI.load();
                commit(FETCHING_FEED_SUCCESS, response.data);
                return response.data;
            } catch (error) {
                commit(FETCHING_FEED_ERROR, error);
                return null;
            }
        }
    }
};