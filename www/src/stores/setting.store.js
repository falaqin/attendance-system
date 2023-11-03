import { defineStore } from 'pinia';
import SettingService from '@/services/SettingService.js';
import { useToast } from "vue-toastification";

export const useSettingStore = defineStore({
    id: 'setting',
    state: () => ({
        settings: [],
    }),
    actions: {
        async index() {
            const service = new SettingService();

            return service.index().then(response => {
                this.settings = response.data.settings;
            })
        },

        update() {
            const toast = useToast();
            const service = new SettingService();

            return service.update(this.settings).then(response => {
                toast.success(response.data.message);
                this.settings = response.data.settings;
            })
        }
    }
})