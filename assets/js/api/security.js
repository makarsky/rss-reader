import axios from 'axios';

export default {
    login(email, password) {
        return axios.post('/api/v1/login', {
            email: email,
            password: password,
        });
    },
    register(email, plainPassword) {
        return axios.post('/api/v1/register', {
            email: email,
            plainPassword: plainPassword,
        });
    },
}