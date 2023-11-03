import axios from 'axios';

export default class StaffService {
    index() {
        return axios.get('/api/admin/staff/index', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }

    create(parameters) {
        return axios.post('/api/admin/staff/create', {
            ...parameters,
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}