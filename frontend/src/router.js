import {createMemoryHistory, createRouter} from "vue-router";
import Users from "@/components/views/UsersView.vue";
import GameView from "@/components/views/GameView.vue";
import RegistrationView from "@/components/views/RegistrationView.vue";
import AuthorizationView from "@/components/views/AuthorizationView.vue";
import StartScreen from "@/components/views/StartScreenView.vue"

const routes = [
    // {path: '/', component: StartScreen},
    {path: '/', component: GameView},
    // {path: '/game', component: GameView},
    {path: '/registration', component: RegistrationView},
    {path: '/authorization', component: AuthorizationView},
    {path: '/users', component: Users}
]

const router = createRouter({
    history: createMemoryHistory(),
    routes,
})
export default router