import { defineStore } from 'pinia';
import StaffDashboardService from '@/services/StaffDashboardService';
import { useToast } from "vue-toastification";
import moment from "moment";

export const useStaffDashboardStore = defineStore({
    id: 'dashboard',
    state: () => ({
        dashboard: {},
        record: []
    }),
    actions: {
        fetch() {
            const service = new StaffDashboardService();

            return service.dashboard().then(response => {
                this.dashboard = response.data.dashboard;
            })
        },

        store(clockIn) {
            const service = new StaffDashboardService();
            const toast = useToast();

            return service.assertClock(clockIn).then(response => {
                toast.success(response.data.message);
            });
        },

        getAll() {
            const service = new StaffDashboardService();
            
            return service.getAttendances().then(response => {
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