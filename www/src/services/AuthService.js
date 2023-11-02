import axios from 'axios';

export default class AuthService {
    login(username, password) {
        return axios.post('api/login', { username, password })
    }

    logout() {
        return axios.get('api/logout', {
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}