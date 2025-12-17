<script setup>
import {onMounted, reactive, ref, provide, computed} from 'vue'
import Level from '../Level.vue'
import WinningStreak from '../Winning_streak.vue';
import AnswerOptions from '../AnswerOptions.vue';
import Layout from '../Layout.vue';
import Emoji from '../Emoji.vue';
import apiClient from "@/utils/api.js";

let films = ref()
let imageUrl = ref(null)
let rightId = ref()
let rightAnswer = ref(null)
let stats = reactive({
  level: null,
  winningStreak: null,
  experience: null
})
const grade = {1: 100, 2: 150, 3: 200, 4: 250, 5: 300, 6: 350}


function getGameData() {
  apiClient.get('/game/getGameData')
      .then(response => {
        films.value = response.data.films.map(film => film.name)

        rightId.value = response.data.films.find(film => film.is_correct === true).id

        rightAnswer.value = response.data.films.find(film => film.id === rightId.value).name

        getFrame(rightId.value)
      })
      .catch(e => {
        console.log('Перехват в getGameData', e)
      })
}

function getFrame(rightId) {
  apiClient.get('/game/getFrame/' + rightId, {
    responseType: 'blob',
    headers: {
      'Cache-Control': 'no-cache',
    },
  })
      .then(response => {
        imageUrl.value = URL.createObjectURL(response.data)
      })
      .catch(e => {
        console.log(e)
      })
}


function saveData() {
  saveLocalData()
  apiClient.post('/game/saveStatistics', stats)
      .then(response => {
        stats.level = response.data.level
        stats.experience = response.data.experience
        stats.winningStreak = response.data.winningStreak
      })
      .catch(e => {
        console.log('saveData:', e)
      })
}

function saveLocalData() {
  let statistics = JSON.parse(localStorage.getItem('stat'))
  statistics.level = stats.level
  statistics.winningStreak = stats.winningStreak
  statistics.experience = stats.experience
  localStorage.setItem('stat', JSON.stringify(statistics))
}

function getStatistics() {
  apiClient.get('/game/getStatistics')
      .then(response => {
        stats.level = response.data.level
        stats.experience = response.data.experience
        stats.winningStreak = response.data.winningStreak
      })
      .catch(e => {
        console.log('saveData:', e)
      })
}


function answer(film) {
  stats.level = (() => {
    if (stats.experience < 1000) {
      return 1
    }
    if (stats.experience >= 1000 && stats.experience <= 2000) {
      return 2
    }
    if (stats.experience >= 2001 && stats.experience <= 3000) {
      return 3
    }
    if (stats.experience >= 3001 && stats.experience <= 4000) {
      return 4
    }
    if (stats.experience >= 4001 && stats.experience <= 5000) {
      return 5
    }
    if (stats.experience >= 5001) {
      return 6
    }
  })();

  if (film === rightAnswer.value) {
    stats.experience += grade[stats.level]
  } else {
    stats.experience -= grade[stats.level]
  }
  saveData()
  getGameData()
}

onMounted(() => {
  getStatistics()
  getGameData()
})

</script>

<template>
  <div class="container">
    <Layout
    >
      <div class="stats-row">
        <Level
            class="component-card level"
            :level="stats.level"
        >

        </Level>

        <WinningStreak
            class="component-card experience"
            :experience="stats.experience"
        >

        </WinningStreak>
      </div>

      <Emoji
          class="component-card emoji-container"
          :imageUrl="imageUrl"
      />

      <AnswerOptions
          class="component-card answer-options"
          :films="films"
          @film=" film => {
            answer(film)
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