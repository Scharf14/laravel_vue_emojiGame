<template>
  <div class="start-screen">
    <h1>🎬 Угадай фильм по эмодзи</h1>
    <p>Проверь свои знания кино!</p>
    <button @click="startGame" class="start-button">Начать игру</button>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

function startGame() {
  router.push({path: '/game'})
}
</script>

<style scoped>
.start-screen {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  text-align: center;
  padding: 20px;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.start-button {
  background: #68904D;
  color: white;
  border: none;
  padding: 15px 30px;
  font-size: 1.2rem;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 20px;
}

.start-button:hover {
  background: #5a8040;
}
</style>