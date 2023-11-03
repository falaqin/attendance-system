import axios from 'axios';

export default class StaffAttendanceService {
    index() {
        return axios.get('/api/admin/attendance', {
            headers: {
                "Content-Type": "application/json",
                'Authorization': `Bearer ${localStorage.getItem('token')}`
            }
        })
    }
}