import axios from 'axios';

export default class StaffDashboardService {
    dashboard() {
        return axios.get('/api/dashboard', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }

    assertClock(clockIn = false) {
        return axios.post('/api/attendance', {
            clock_in: clockIn
        }, {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }

    getAttendances() {
        return axios.get('/api/attendance', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}