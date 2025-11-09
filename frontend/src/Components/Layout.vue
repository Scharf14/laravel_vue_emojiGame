<script setup>
import apiClient from "@/utils/api.js";
import {useRouter} from 'vue-router';

const props = defineProps({
  lvlUser: Number,
  exp: Number
})

const router = useRouter();
function logout() {
  apiClient.post('/auth/logout')
      .then(function(response) {
        localStorage.removeItem('token')
        router.push('/')
      })
      .catch(response => console.log(response))
}

</script>

<template>
  <div class="container">
    <header>
      <div class="component-card layout">
        <nav>
          <ul>
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
              <router-link to="/" class="router-link">Играть</router-link>
            </li>
            <li>
              <div class="exp"> Кол-во exp: {{ exp }}</div>
              <br>
              <div class="lvl"> Уровень: {{ lvlUser }}</div>
            </li>
            <li><a href="#"><img src="../../public/minion.jpeg" alt=""></a></li>
          </ul>
        </nav>
      </div>
    </header>
  </div>
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