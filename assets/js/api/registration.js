import axios from 'axios';

export default {
    register(email, plainPassword) {
        return axios.post('/auth/register', {
            email: email,
            plainPassword: plainPassword,
        });
    },
    checkEmail(email) {
        return axios.post('/auth/check-email', {
            email: email,
        });
    },
}