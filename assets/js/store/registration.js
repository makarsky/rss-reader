import RegistrationAPI from '../api/registration';

const REGISTRATION = 'REGISTRATION',
    REGISTRATION_SUCCESS = 'REGISTRATION_SUCCESS',
    REGISTRATION_ERROR = 'REGISTRATION_ERROR',
    RESET_ERROR = 'RESET_ERROR',
    GENERAL_ERROR = 'GENERAL_ERROR';

export default {
    namespaced: true,
    state: {
        isLoading: false,
        registrationErrors: null,
        error: null,
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasRegistrationErrors(state) {
            return state.registrationErrors !== null;
        },
        registrationErrors(state) {
            return state.registrationErrors;
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
            state.registrationErrors = null;
            state.error = null;
        },
        [REGISTRATION_SUCCESS](state) {
            state.isLoading = false;
            state.registrationErrors = null;
            state.error = null;
        },
        [REGISTRATION_ERROR](state, errors) {
            state.isLoading = false;
            state.registrationErrors = state.registrationErrors ? Object.assign(state.registrationErrors, errors) : errors;
            state.error = null;
        },
        [RESET_ERROR](state, propName) {
            state.isLoading = false;
            state.error = null;

            if (state.registrationErrors) {
                delete state.registrationErrors[propName]
            } else {
                state.registrationErrors = null;
            }
        },
        [GENERAL_ERROR](state, error) {
            state.isLoading = false;
            state.registrationErrors = null;
            state.error = error;
        },
    },
    actions: {
        async register({commit}, payload) {
            commit(REGISTRATION);
            try {
                let response = await RegistrationAPI.register(payload.email, payload.plainPassword);

                if (response.data.errors) {
                    commit(REGISTRATION_ERROR, response.data.errors);
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

                if (response.data.errors) {
                    commit(REGISTRATION_ERROR, response.data.errors);
                    return null;
                }

                commit(RESET_ERROR, 'email');
            } catch (error) {
                commit(GENERAL_ERROR, error);
            }
        },
        async resetError({commit}, propName) {
            commit(RESET_ERROR, propName);
        },
    }
}