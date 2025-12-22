<script setup>
import {computed, onMounted, reactive, ref} from 'vue'
import Level from '../Level.vue'
import WinningStreak from '../Winning_streak.vue';
import AnswerOptions from '../AnswerOptions.vue';
import Layout from '../Layout.vue';
import Emoji from '../Emoji.vue';
import apiClient from "@/utils/api.js";
import {useGameStatStore} from "../../../stores/GameStatistics.js";

const films = ref()
const imageUrl = ref(null)
const rightId = ref()
const rightAnswer = ref(null)
const storage = useGameStatStore()

const computedLevel = computed(() => {
  return Math.floor(stats.experience / 1000)
})

const stats = reactive({
  level: computedLevel,
  winningStreak: null,
  experience: null
})

const streakTiers = [
  {streak: 0, bonus: 0},
  {streak: 3, bonus: 150},
  {streak: 6, bonus: 300},
  {streak: 9, bonus: 450}
]

function getGameData() {
  apiClient.get('/game/data')
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
  apiClient.get('/game/frame/' + rightId, {
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
  apiClient.post('/game/saveStatistics', stats)
      .then(response => {
        stats.experience = response.data.experience
        stats.winningStreak = response.data.winningStreak
      })
      .catch(e => {
        console.log('saveData:', e)
      })
}



function getStatistics() {
  apiClient.get('/game/statistics')
      .then(response => {
        stats.experience = response.data.experience
        stats.winningStreak = response.data.winningStreak
      })
      .catch(e => {
        console.log('saveData:', e)
      })
}

function getStreakBonus() {
  const arr = streakTiers.length
  for (let i = arr - 1; i >= 0; i--) {
    if (stats.winningStreak >= streakTiers[i].streak) {
      return streakTiers[i].bonus
    }
  }
  return 0
}

function answer(film) {
  const flag = film === rightAnswer.value
  const bonus = getStreakBonus()
  if (flag) {
    stats.winningStreak++
    stats.experience += 100 + bonus

  } else {
    stats.winningStreak = 0
    stats.experience -= 200
  }


  storage.stats = stats
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
            :level="computedLevel"
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