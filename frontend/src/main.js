import {createApp} from 'vue'
import App from '@/Components/App.vue'
import router from './router.js'

createApp(App)
    .use(router)
    .mount('#app');

