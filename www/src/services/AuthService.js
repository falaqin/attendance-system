import axios from 'axios';

export default class AuthService {
    login(username, password) {
        return axios.post('/api/login', { username, password })
    }

    logout() {
        return axios.get('/api/logout', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}