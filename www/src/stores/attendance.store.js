import { defineStore } from 'pinia';
import StaffAttendanceService from '@/services/StaffAttendanceService.js';
import moment from 'moment';

export const useAttendanceStore = defineStore({
    id: 'attendance',
    state: () => ({
        record: [],
    }),
    actions: {
        async index() {
            const service = new StaffAttendanceService();

            return service.index().then(response => {
                response.data.record.forEach(rec => {
                    rec.time_clocked_in = moment(rec.time_clocked_in).format('MMMM Do YYYY, HH:mm:ss');
                    rec.created_at = moment(rec.created_at).format('MMMM Do YYYY, HH:mm:ss');
                    if (rec.time_clocked_out) {
                        rec.time_clocked_out = moment(rec.time_clocked_out).format('MMMM Do YYYY, HH:mm:ss');
                    }
                })

                this.record = response.data.record;

            })
        }
    }
})