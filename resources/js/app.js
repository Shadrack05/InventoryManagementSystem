import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from "vue";
import { createPinia } from "pinia";
import dashboard from "./components/dashboard.vue";

const el = document.getElementById('app')

if (el) {
    const pinia = createPinia();

    const app = createApp({
        components: {
            dashboard,
        },
    });

    app.use(pinia);
    app.mount("#app");
}
