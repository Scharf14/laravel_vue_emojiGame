<script setup>
import {useRouter} from 'vue-router';
import {reactive} from "vue";
import axios from 'axios';
import apiClient from "@/utils/api.js";
import {ref} from "vue";

const newUser = reactive({
  name: '',
  email: '',
  password: '',
})

const router = useRouter()

function register() {
  apiClient.post('/auth/register', newUser)
      .then(function (response) {
        localStorage.setItem('stat', JSON.stringify(response.data.stat))
        localStorage.setItem('user', JSON.stringify(response.data.user))
        localStorage.setItem('avatar', JSON.stringify(response.data.avatar))
        localStorage.setItem('token', response.data.token)
        router.push('/')
      })
      .catch(response => console.log(response))
}
</script>

<template>
  <div class="register-container">
    <div class="register-card">
      <h2 class="title">Регистрация</h2>
      <form class="register-form" @submit.prevent="register">
        <div class="input-group">
          <label class="label">Имя</label>
          <input
              v-model="newUser.name"
              type="text"
              class="input"
              placeholder="Введите ваше имя"
              required
          >
        </div>

        <div class="input-group">
          <label class="label">Email</label>
          <input
              v-model="newUser.email"
              type="email"
              class="input"
              placeholder="Введите ваш email"
              required
          >
        </div>

        <div class="input-group">
          <label class="label">Пароль</label>
          <input
              v-model="newUser.password"
              type="password"
              class="input"
              placeholder="Введите пароль"
              required
          >
        </div>

        <button @click="register" type="button" class="register-button">
          Зарегистрироваться
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.register-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.register-card {
  background: white;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

.title {
  text-align: center;
  color: #333;
  margin-bottom: 2rem;
  font-size: 1.5rem;
  font-weight: 600;
}

.register-form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.input-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.label {
  font-weight: 500;
  color: #555;
  font-size: 0.9rem;
}

.input {
  padding: 0.75rem;
  border: 2px solid #e1e5e9;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background-color: #f8f9fa;
}

.input:focus {
  outline: none;
  border-color: #667eea;
  background-color: white;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.input::placeholder {
  color: #a0a0a0;
}

.register-button {
  background: #EE9B01;
  color: white;
  border: none;
  padding: 0.875rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  margin-top: 0.5rem;
}

.register-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.register-button:active {
  transform: translateY(0);
}
</style>