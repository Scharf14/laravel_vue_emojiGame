import {createWebHistory, createRouter} from "vue-router";
import GameView from "@/Components/Pages/GamePage.vue";
import RegistrationView from "@/Components/Pages/RegistrationPage.vue";
import AuthorizationView from "@/Components/Pages/AuthorizationPage.vue";
import StartScreen from "@/Components/Pages/StartScreenPage.vue";
import UserDataView from "@/Components/Pages/UserDataPage.vue";
import AdminPanel from "@/Components/Pages/AdminPanelPage.vue";

const routes = [
    {path: '/', component: StartScreen},
    {path: '/game', component: GameView},
    {path: '/registration', component: RegistrationView},
    {path: '/authorization', component: AuthorizationView},
    {path: '/profile', component: UserDataView},
    {path: '/admin', component: AdminPanel},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})
export default router