<script setup>
import {ref, onMounted} from 'vue'
import apiClient from "@/utils/api.js";
import axios from "axios";
import router from "@/router.js";

const props = defineProps({
  answerOptions: Array
})

const emit = defineEmits(['correctAnswer'])

function sendAnswer(answer) {
  emit('correctAnswer', answer)
}


</script>

<template>
  <div class="options-container">
    <div class="main-bar">
      <h2>Варианты ответа</h2>
      <div class="answers">
        <button
            v-for="answer in answerOptions"
            @click="sendAnswer(answer)"
        >
          {{ answer }}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>

.options-container {
  max-width: 600px;
  margin: 30px auto;
  padding: 0 20px;
  font-family: 'Arial', sans-serif;
}

.main-bar {
  background: white;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  border: 2px solid #68904D;
}

.main-bar h2 {
  margin: 0 0 25px 0;
  font-size: 22px;
  font-weight: bold;
  text-align: center;
  color: #68904D;
}

.answers {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.answers button {
  display: block;
  width: 100%;
  padding: 15px 20px;
  border: none;
  border-radius: 8px;
  background: #f8f9fa;
  color: #333;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  border-left: 4px solid cadetblue;
}

.answers button:hover {
  background: #68904D;
  color: white;
  transform: translateX(5px);
}

.answers button:active {
  transform: translateX(2px);
}

.answers button:focus-visible {
  outline: 2px solid #EE9B01;
  outline-offset: 2px;
}


</style>