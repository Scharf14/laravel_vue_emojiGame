import {createApp} from 'vue'
import {createPinia} from 'pinia'
import App from '@/Components/App.vue'
import router from './router.js'


createApp(App)
    .use(createPinia())
    .use(router)
    .mount('#app');

