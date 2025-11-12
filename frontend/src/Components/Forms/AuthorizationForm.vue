<script setup>
import {useRouter} from 'vue-router';
import {reactive} from "vue";
import apiClient from "../../utils/api.js";

const authUser = reactive({
  email: '',
  password: '',
})

const router = useRouter()

function login() {
  apiClient.post('/auth/login', authUser)
      .then(function (response) {
        localStorage.setItem('token', response.data.token)
        router.push('/')
      })
      .catch(response => console.log(response))
}

</script>

<template>
  <div class="login-container">
    <div class="login-form">
      <div class="input-group">
        <input
            v-model="authUser.email"
            type="email"
            placeholder="Email"
            class="input-field"
        >
      </div>

      <div class="input-group">
        <input
            v-model="authUser.password"
            type="password"
            placeholder="Password"
            class="input-field"
        >
      </div>

      <button @click="login" type="button" class="login-button">
        Войти
      </button>
    </div>
  </div>
</template>

<style scoped>
.login-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.login-form {
  background: white;
  padding: 2rem;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 320px;
}

.input-group {
  margin-bottom: 1.5rem;
}

.input-field {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e1e5e9;
  border-radius: 8px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background-color: #f8f9fa;
  box-sizing: border-box;
}

.input-field:focus {
  outline: none;
  border-color: #667eea;
  background-color: white;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.input-field::placeholder {
  color: #a0a0a0;
}

.login-button {
  width: 100%;
  background: #EE9B01;
  color: white;
  border: none;
  padding: 0.875rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
}

.login-button:hover {
  background: #5a6fd8;
  transform: translateY(-1px);
}

.login-button:active {
  transform: translateY(0);
}
</style>