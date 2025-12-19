<script setup>
import apiClient from "@/utils/api.js";
import {useRouter} from 'vue-router';
import {onMounted, reactive, ref} from "vue";

const router = useRouter();
const avatar = ref(null);

const props = defineProps({
  level: Number,
  winningStreak: Number
})

const level = ref()
const winningStreak = ref()

// const stat = JSON.parse(localStorage.getItem('stat'))

function options() {
  if (props.level && props.winningStreak) {
    return true
  } else {
    return false
  }
}


function logout() {
  console.log('1. Начало logout')
  console.log('2. Токен в localStorage:', localStorage.getItem('token'))

  apiClient.post('/auth/logout')
      .then(response => {
        console.log('3. Ответ от сервера:', response.status, response.data)

        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('stat')

        console.log('4. После удаления, токен:', localStorage.getItem('token'))

        router.push('/authorization')
      })
      .catch(error => {
        console.error('5. Ошибка logout:', {
          message: error.message,
          status: error.response?.status,
          data: error.response?.data
        })
      })
}

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

const handleStorageChange = (event) => {
  if (event.key === 'stat') {
    level.value = JSON.parse(event.newValue).level || ''
    winningStreak.value = JSON.parse(event.newValue).winningStreak || ''
    console.log(winningStreak.value)
  }
}

onMounted(() => {
  window.addEventListener('storage', handleStorageChange)
  getAvatar()
})
</script>

<template>
  <div class="container">
    <header>
      <div class="component-card layout">
        <nav>
          <ul>
            <li>
              <router-link to="/admin" class="router-link">Admin panel</router-link>
            </li>
            <li>
              <router-link to="/registration" class="router-link">Registration</router-link>
            </li>
            <li>
              <router-link to="/authorization" class="router-link">login</router-link>
            </li>
            <li @click="logout">
              <router-link to="/authorization" class="router-link">logout</router-link>
            </li>
            <li>
              <router-link to="/game" class="router-link">Play</router-link>
            </li>
            <li>
              <div class="exp"> Winning streak: {{ winningStreak }}</div>
              <br>
              <div class="exp"> Level: {{ level }}</div>

            </li>
            <li>
              <router-link to="/profile"><img :src="avatar"></router-link>
            </li>
          </ul>
        </nav>
      </div>
    </header>
  </div>
  <slot></slot>
</template>

<style scoped>

.container {
  padding: 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.layout {
  background: linear-gradient(135deg, cadetblue 0%, #5f9ea0 100%);
  color: white;
  text-align: center;
}

a, .router-link {
  text-decoration: none;
  color: white;
}

ul {
  list-style: none;
  background: #68904D;
  display: flex;
  justify-content: end;
}

li {
  padding: 10px 30px;
}

img {
  width: 80px;
  height: 90px; /* фиксированная высота */
  object-fit: cover;
}

.exp {
  text-align: left;
}

.lvl {
  text-align: left;
}
</style>