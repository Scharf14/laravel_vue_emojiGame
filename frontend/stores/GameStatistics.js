import {defineStore} from 'pinia'
import {computed, reactive, ref} from 'vue'
import api from "@/utils/api.js";
import axios from "axios";
import apiClient from "@/utils/api.js";
export const useGameStatStore = defineStore('gameStats', () => {
    const stats = reactive({
        winningStreak: null,
        level: null,
        experience: null
    })

    function getStats() {

        apiClient.get('/game/statistics')
            .then(response => {
                stats.winningStreak = response.data.winningStreak
                stats.experience = response.data.experience
            })
    }
    return {
        stats,
        getStats
    }
})

