import './bootstrap';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHashHistory } from 'vue-router';
import Routes from './routes';

const app = createApp({});

const router = createRouter({
    routes : Routes,
    history: createWebHashHistory(),
});

app.use(router);
app.mount('#app');

