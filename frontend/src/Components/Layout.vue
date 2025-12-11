<script setup>
import apiClient from "@/utils/api.js";
import {useRouter} from 'vue-router';
import {ref, onMounted, computed} from "vue";

const props = defineProps({
  level: Number,
  experience: Number,
  winstreak: Number,
  avatarPath: String
})

const defaultImage = '../../public/face.jpeg'
const router = useRouter();


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
</script>

<template>
  <div class="container">
    <header>
      <div class="component-card layout">
        <nav>
          <ul>
            <li>
              <router-link to="/admin" class="router-link">Админ</router-link>
            </li>
            <li>
              <router-link to="/registration" class="router-link">Зарегистрироваться</router-link>
            </li>
            <li>
              <router-link to="/authorization" class="router-link">Войти</router-link>
            </li>
            <li @click="logout">
              <router-link to="/authorization" class="router-link">Выйти</router-link>
            </li>
            <li>
              <router-link to="/game" class="router-link">Играть</router-link>
            </li>
            <li>
              <div class="exp"> Серия побед: {{ }}</div>
              <br>
              <div class="lvl"> Уровень: {{ }}</div>
            </li>
            <li>
              <router-link to="/userData"><img :src="defaultImage"></router-link>
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
  width: 50px;
  height: 70px;
  background: #fff;
  border: 4px solid #8ea6b7;
  border-radius: 10px;
}

.exp {
  text-align: left;
}

.lvl {
  text-align: left;
}
</style>