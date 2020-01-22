import axios from 'axios';

export default {
    load() {
        return axios.get('/api/v1/feed');
    },
}