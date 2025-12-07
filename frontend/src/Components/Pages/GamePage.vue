<script setup>
import {onMounted, reactive, ref} from 'vue'
import Level from '../Level.vue'
import Winstreak from '../Winstreak.vue';
import AnswerOptions from '../AnswerOptions.vue';
import Layout from '../Layout.vue';
import Emoji from '../Emoji.vue';
import axios from "axios";
import apiClient from "@/utils/api.js";
import api from "@/utils/api.js";


let answerOptions = ref()
let films = ref() // Нужно понять, как мне отобразить правильный фильм среди кучи
let stats = ref({
  level: 1,
  winstreak: 0,
  experience: 0
})
let imageUrl = ref(null)
let correctId = ref()
function showData(id) {
  console.log('your Frame:' + id)
}

function getGameData() {
  apiClient.get('http://localhost:8000/api/game/getGameData')
      .then(response => {
        films.value = response.data.films.map(film => film.name)
        return correctId.value = response.data.films.find(film => film.is_correct === true).id
      }).catch(response => {
    console.log(response)
  }).then(corId => {
    getFrame(corId)
    showData(corId)
  })
}

function getFrame(corId) {
  console.log(corId)
  console.log('getframe:')
  apiClient.get('http://localhost:8000/api/game/getFrame', {
    responseType: 'blob',
    headers: {
      'Cache-Control': 'no-cache',
    },
    params: {
      id: corId
    }
  })
      .then(response => {
        imageUrl.value = URL.createObjectURL(response.data)
      }).catch(response => {
    console.log(response)
  })
}


onMounted(() => {
  getGameData()
})


</script>

<template>
  <div class="container">
    <Layout
        :level="stats.level"
        :experience="stats.experience"
        :winstreak="stats.winstreak"
    >
      <div class="stats-row">
        <Level
            class="component-card level"
            :level="stats.level"
        >

        </Level>

        <Winstreak
            class="component-card experience"
            :experience="stats.experience"
        >

        </Winstreak>
      </div>

      <Emoji
          class="component-card emoji-container"
          :imageUrl="imageUrl"
      />

      <AnswerOptions
          class="component-card answer-options"
          :films="films"
          @correctAnswer=" answer => {

          // addExp(answer)
          // changeFilm(answer)
          // nextLevel()
        }"
      >
      </AnswerOptions>
    </Layout>

  </div>
</template>

<style>
* {
  padding: 0;
  margin: 0;
}

/* Общий стиль для всех компонентов */
.component-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  margin-bottom: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  border: 1px solid #e1e5e9;
}

/* Специфичные стили для каждого компонента */
.layout {
  background: linear-gradient(135deg, cadetblue 0%, #5f9ea0 100%);
  color: white;
  text-align: center;
}

.level {
  background: #68904D;
  color: white;
  font-weight: bold;
}

.experience {
  background: #EE9B01;
  color: white;
  font-weight: bold;
}

.emoji-container {
  text-align: center;
  font-size: 3rem;
  background: #f8f9fa;
  border: 2px dashed #68904D;
}

/* Стили для вариантов ответов */
.answer-options {
  background: white;
}

/* Состояния для правильных/неправильных ответов */
.correct {
  border: 3px solid #68904D;
  background: #f0f9f0;
}

.incorrect {
  border: 3px solid #dc3545;
  background: #fdf2f2;
}

.feedback {
  text-align: center;
  padding: 10px;
  margin-top: 10px;
  border-radius: 6px;
  font-weight: bold;
}

.feedback.correct {
  color: #68904D;
  background: #f0f9f0;
}

.feedback.incorrect {
  color: #dc3545;
  background: #fdf2f2;
}
</style>