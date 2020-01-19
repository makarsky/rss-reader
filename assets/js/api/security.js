import axios from 'axios';

export default {
    login(email, password) {
        console.log(email, password);
        return axios.post('/api/v1/login', {
            email: email,
            password: password
        });
    }
}