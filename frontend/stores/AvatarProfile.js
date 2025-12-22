import apiClient from "@/utils/api.js";
import {defineStore} from "pinia";
import {reactive, ref} from 'vue'

export const useAvatarStore = defineStore('avatar', () => {
    const avatar = ref('')

    function getAvatar() {
        apiClient.get('/profile/getAvatar', {
            responseType: 'blob',
            headers: {
                'Cache-control': 'no-cache'
            }
        })
            .then(response => {
                avatar.value = URL.createObjectURL(response.data)
            })
            .catch(e => {
                console.log('loadAvatar', e)
            })
    }

    return {
        avatar,
        getAvatar
    }
})


