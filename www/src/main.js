import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

// Toast
import Toast from "vue-toastification";
import "vue-toastification/dist/index.css";

// Global components
import PrimaryButton from '@/components/PrimaryButton.vue'
import SecondaryButton from '@/components/SecondaryButton.vue'
import DangerButton from '@/components/DangerButton.vue'

import App from './App.vue'
import router from './router'

const app = createApp(App)

app.use(createPinia())
app.use(router)
app.use(Toast);

app.component('primary-button', PrimaryButton);
app.component('secondary-button', SecondaryButton);
app.component('danger-button', DangerButton);

app.mount('#app')
