import { createApp } from 'vue';
import MainApp from './MainApp.vue';
import router from './router';
import './assets/main.css';

createApp(MainApp).use(router).mount('#app');


