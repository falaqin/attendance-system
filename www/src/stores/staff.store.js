import { defineStore } from 'pinia';
import StaffService from '@/services/StaffService.js';
import moment from 'moment';

export const useStaffStore = defineStore({
    id: 'staff',
    state: () => ({
        staffs: [],
    }),
    actions: {
        async index() {
            const staffService = new StaffService();

            return staffService.index().then(response => {
                this.staffs = response.data.staffs;
            })
        },

        async create(parameters) {
            const staffService = new StaffService();

            return staffService.create(parameters).then(response => {
                response.data.staff.created_at = moment(response.data.staff.created_at).format('MMMM Do YYYY');
                this.staffs.push(response.data.staff)
                this.staffs.sort(function(a, b) { 
                    return - (a.id - b.id)
                });
            });
        }
    }
})