import { defineStore } from 'pinia';
import AuthService from '@/services/AuthService.js'
import { useToast } from "vue-toastification";
import router from "@/router/index.js";

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        // initialize state from local storage to enable user to stay logged in
        user: JSON.parse(localStorage.getItem('user')),
        token: localStorage.getItem('token'),
        admin: JSON.parse(localStorage.getItem('admin')),
        returnUrl: null
    }),
    actions: {
        async login(username, password) {
            const toast = useToast();
            const authService = new AuthService();

            return authService.login(username, password).then(response => {
                this.user = response.data.user;
                this.token = response.data.token;
                this.admin = response.data.user.admin == 1;
                
                localStorage.setItem('user', JSON.stringify(this.user));
                localStorage.setItem('token', this.token);
                localStorage.setItem('admin', this.admin);
                
                if (this.admin) {
                    router.push('/admin/dashboard');
                } else {
                    router.push(this.returnUrl || '/');
                }

            }).catch(e => {
                toast.error(e.response.data.message);
            })
        },

        logout() {
            const authService = new AuthService();
            authService.logout().then(response => {
                this.user = this.token = null;
                this.admin = false;
                localStorage.removeItem('user');
                localStorage.removeItem('token');
                router.push('/login');
            });
        }
    }
});
