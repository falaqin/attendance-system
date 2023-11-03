import axios from 'axios';

export default class SettingService {
    index(username, password) {
        return axios.get('/api/admin/settings', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }

    update(parameters) {
        return axios.post('/api/admin/settings', parameters, {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}