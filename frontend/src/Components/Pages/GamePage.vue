<script setup>
import {onMounted, reactive, ref} from 'vue'
import Level from '../Level.vue'
import Winstreak from '../Winstreak.vue';
import AnswerOptions from '../AnswerOptions.vue';
import Layout from '../Layout.vue';
import Emoji from '../Emoji.vue';
import axios from "axios";
import apiClient from "@/utils/api.js";

// const correctFilm = ref(getRandomFilmByUserLevel())
// const film = ref(correctFilm.value.films)
let user = ref({})
let answerOptions = ref([]) // список с вариантами ответов из запроса
let frameFilm = ref(null) // имя фильма из которого был взят кадр
let stats = ref({
  level: 1,
  winstreak: 0,
  experience: 0
})

function getFilms() {
  apiClient.get('http://localhost:8000/api/game/index')
      .then(response => {
        answerOptions.value = response.data.films
        frameFilm.value = response.data.nameFilm.id
        stats.value = response.data.stats
        user.value = response.data.user
        console.log(response.data.nameFilm)
      }).catch(response => {
    console.log(response)
  })
}

const savedData = localStorage.getItem('stats')

if (savedData) {
  stats.value = JSON.parse(savedData)
}

function saveData() {
  localStorage.setItem('stats', JSON.stringify(stats.value))
}

function getRandomFilmByUserLevel() {
  const activeFilms = films.value.filter(film => film.difficult_id <= progress.value.lvlUser)
  const randomIndex = Math.floor(Math.random() * activeFilms.length)
  return activeFilms[randomIndex]
}


function getRandomFilm(correctFilmId = null) {
  const randomIndex = Math.floor(Math.random() * films.value.length)
  if (correctFilmId !== null) {
    return films.value.filter(film => film.id !== correctFilmId)[randomIndex]
  }
  return films.value[randomIndex]
}


// function createAnswerOptions() {
//   const answerOptions = []
//
//   while (answerOptions.length < 2) {
//     const wrongFilm = getRandomFilm(correctFilm.value.id)
//
//     if (!answerOptions.includes(wrongFilm.name)) {
//       answerOptions.push(wrongFilm.name)
//     }
//   }
//   const randomIndexOptions = Math.floor(Math.random() * 3)
//   answerOptions.splice(randomIndexOptions, 0, correctFilm.value.name)
//   return answerOptions
// }

// const answerOptions = ref(createAnswerOptions())

function changeFilm(answer) {
  if (answer === correctFilm.value.name) {
    progress.value.winStreak++
  } else {
    progress.value.winStreak = 0
  }
  correctFilm.value = getRandomFilmByUserLevel()
  film.value = correctFilm.value.films
  answerOptions.value = createAnswerOptions()
  saveData()
}

function addExp(answer) {
  const obj = {
    0: 100,
    1: 150,
    2: 200,
    3: 250,
    4: 300
  }

  if (answer === correctFilm.value.name) {
    progress.value.exp += obj[progress.value.lvlGame]
  } else {
    progress.value.exp -= obj[progress.value.lvlGame]
  }
  saveData()
}

function nextLevel() {
  const oldLevel = progress.value.lvlUser
  if (progress.value.winStreak === 3) {
    progress.value.lvlGame++
    progress.value.winStreak = 0
  }
  if (progress.value.exp < 500) {
    progress.value.lvlUser = 0
  }
  if (progress.value.exp >= 500) {
    progress.value.lvlUser = 1
  }
  if (progress.value.exp >= 1000) {
    progress.value.lvlUser = 2
  }
  if (progress.value.exp >= 1500) {
    progress.value.lvlUser = 3
  }
  if (progress.value.exp >= 2000) {
    progress.value.lvlUser = 4
  }
  if (progress.value.lvlUser !== oldLevel) {
    correctFilm.value = getRandomFilmByUserLevel()
    emoji.value = correctFilm.value.emojies
    answerOptions.value = createAnswerOptions()
  }

  if (progress.value.lvlGame === 6) {
    alert('вы достигли максимального уровня')
    progress.value.lvlGame = 0
    progress.value.exp = 0
    progress.value.lvlUser = 0
  }
  saveData()
}

onMounted(() => {
  getFilms()
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
          :frameFilm="frameFilm"
      />

      <AnswerOptions
          class="component-card answer-options"
          :answerOptions="answerOptions"
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