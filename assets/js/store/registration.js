import RegistrationAPI from '../api/registration';

const REGISTRATION = 'REGISTRATION',
    REGISTRATION_SUCCESS = 'REGISTRATION_SUCCESS',
    REGISTRATION_ERROR = 'REGISTRATION_ERROR',
    RESET_ERROR = 'RESET_ERROR';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        error: null,
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
    },
    mutations: {
        [REGISTRATION](state) {
            state.isLoading = true;
            state.error = null;
        },
        [REGISTRATION_SUCCESS](state) {
            state.isLoading = false;
            state.error = null;
        },
        [REGISTRATION_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
        },
        [RESET_ERROR](state) {
            state.error = null;
        },
    },
    actions: {
        async register({commit}, payload) {
            commit(REGISTRATION);
            try {
                let response = await RegistrationAPI.register(payload.email, payload.plainPassword);

                if (response.data.errors) {
                    commit(REGISTRATION_ERROR, response.data.errors[0]);
                    return null;
                }
                commit(REGISTRATION_SUCCESS);
                return response.data;
            } catch (error) {
                commit(REGISTRATION_ERROR, error);
                return null;
            }
        },
        async checkEmail({commit}, payload) {
            try {
                let response = await RegistrationAPI.checkEmail(payload.email);

                if (!response.data.available) {
                    commit(REGISTRATION_ERROR, 'There is already an account with this email');
                    return null;
                }
                commit(RESET_ERROR);
            } catch (error) {
                commit(REGISTRATION_ERROR, error);
            }
        },
    }
}