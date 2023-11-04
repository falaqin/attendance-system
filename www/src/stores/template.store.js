import { defineStore } from 'pinia';
// import AnyService from '@/services/AnyService';
import { useToast } from "vue-toastification";

export const useSettingStore = defineStore({
    id: 'dashboard',
    state: () => ({
        dashboard: [],
    }),
    actions: {
        async dashboard() {
            // const service = new StaffDashboardService();

            // return service.dashboard().then(response => {
            //     this.dashboard = response.data.dashboard;
            // })
        },
    }
})