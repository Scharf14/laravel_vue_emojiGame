import {createMemoryHistory, createRouter} from "vue-router";
import GameView from "@/Components/Pages/GamePage.vue";
import RegistrationView from "@/Components/Pages/RegistrationPage.vue";
import AuthorizationView from "@/Components/Pages/AuthorizationPage.vue";
import StartScreen from "@/Components/Pages/StartScreenPage.vue"

const routes = [
    // {path: '/', component: StartScreen},
    {path: '/', component: GameView},
    // {path: '/game', component: GameView},
    {path: '/registration', component: RegistrationView},
    {path: '/authorization', component: AuthorizationView},
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})
export default router