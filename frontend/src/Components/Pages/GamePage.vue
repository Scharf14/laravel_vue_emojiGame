<script setup>
import {ref} from 'vue'
import Level from '../Level.vue'
import Winstreak from '../Winstreak.vue';
import AnswerOptions from '../AnswerOptions.vue';
import Layout from '../Layout.vue';
import Emoji from '../Emoji.vue'

const films = ref([
  {id: 0, film_file_path: '...', difficult_id: 0, name: 'Титаник', emojies: '🚢🧊💔'},
  {id: 1, film_file_path: '...', difficult_id: 0, name: 'Гарри Подтёр', emojies: '🧙‍♂️⚡️👓'},
  {id: 2, film_file_path: '...', difficult_id: 0, name: 'Принцесса и лягушка', emojies: '👸🐸💋'},
  {id: 3, film_file_path: '...', difficult_id: 1, name: 'Одержимость', emojies: '🥁🔥'},
  {id: 4, film_file_path: '...', difficult_id: 1, name: 'Кунг-фу панда', emojies: '🐼🥋🍜'},
  {id: 5, film_file_path: '...', difficult_id: 1, name: 'Алладин', emojies: '🧞‍♂️🔮🌴'},
  {id: 6, film_file_path: '...', difficult_id: 1, name: 'Рататуй', emojies: '🐀👦🍳'},
  {id: 7, film_file_path: '...', difficult_id: 2, name: 'В поисках Немо', emojies: '🐠🐟🔍'},
  {id: 8, film_file_path: '...', difficult_id: 2, name: 'Один дома', emojies: '👦🏠✈️'},
  {id: 9, film_file_path: '...', difficult_id: 2, name: 'Трое в лодке, не считая собаки', emojies: '3️⃣🚣🐕'},
  {id: 10, film_file_path: '...', difficult_id: 2, name: 'Охотники за привидениями', emojies: '👻🚫'},
  {id: 11, film_file_path: '...', difficult_id: 3, name: 'Крепкий орешек', emojies: '💪🥜'},
  {id: 12, film_file_path: '...', difficult_id: 3, name: 'Достучаться до небес', emojies: '👊☁️'},
  {id: 13, film_file_path: '...', difficult_id: 3, name: 'Молчание ягнят', emojies: '🔇🐑'},
  {id: 14, film_file_path: '...', difficult_id: 3, name: 'Планета обезьян', emojies: '🌍🐒'},
  {id: 15, film_file_path: '...', difficult_id: 4, name: 'В джазе только девушки', emojies: '🎺👩‍❤️‍👩'},
  {id: 16, film_file_path: '...', difficult_id: 4, name: 'Пила', emojies: '🪚⚰️'},
  {id: 17, film_file_path: '...', difficult_id: 4, name: 'Хороший, плохой, злой', emojies: '😇😈😠'},
  {id: 18, film_file_path: '...', difficult_id: 4, name: 'Эдвард Руки-ножницы', emojies: '👦🏻👐🏻✂️'}
])

const progress = ref({
  lvlGame: 0,
  lvlUser: 0,
  winStreak: 0,
  exp: 0
})

const savedData = localStorage.getItem('progress')
if (savedData) {
  progress.value = JSON.parse(savedData)
}

function saveData() {
  localStorage.setItem('progress', JSON.stringify(progress.value))
}

function getRandomFilmByUserLevel() {
  const activeFilms = films.value.filter(film => film.difficult_id <= progress.value.lvlUser)
  const randomIndex = Math.floor(Math.random() * activeFilms.length)
  return activeFilms[randomIndex]
}

function getRandomFilm(correctFilmId = null) {
  const randomIndex = Math.floor(Math.random() * films.value.length - (correctFilmId ? 2 : 1))
  if (correctFilmId !== null) {
    return films.value.filter(film => film.id !== correctFilmId)[randomIndex]
  }
  return films.value[randomIndex]
}

const correctFilm = ref(getRandomFilmByUserLevel())
const emoji = ref(correctFilm.value.emojies)

function createAnswerOptions() {
  const answerOptions = []

  while (answerOptions.length < 2) {
    const wrongFilm = getRandomFilm(correctFilm.value.id)

    if (!answerOptions.includes(wrongFilm.name)) {
      answerOptions.push(wrongFilm.name)
    }
  }
  const randomIndexOptions = Math.floor(Math.random() * 3)
  answerOptions.splice(randomIndexOptions, 0, correctFilm.value.name)
  return answerOptions
}

const answerOptions = ref(createAnswerOptions())

function changeFilm(answer) {
  if (answer === correctFilm.value.name) {
    progress.value.winStreak++
  } else {
    progress.value.winStreak = 0
  }
  correctFilm.value = getRandomFilmByUserLevel()
  emoji.value = correctFilm.value.emojies
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

</script>

<template>
  <div class="container">
    <Layout
        :lvlUser="progress.lvlUser"
        :exp="progress.exp"
    >
    </Layout>
    <div class="stats-row">
      <Level
          class="component-card level"
          :lvlGame="progress.lvlGame"
      >

      </Level>

      <Winstreak
          class="component-card winstreak"
          :winStreak="progress.winStreak"
      >

      </Winstreak>
    </div>

    <Emoji
        class="component-card emoji-container"
        :emoji="emoji"
    />
    <AnswerOptions
        class="component-card answer-options"
        :answerOptions="answerOptions"
        @sendAnswer="answer => {
          addExp(answer)
          changeFilm(answer)
          nextLevel()
        }"
    >
    </AnswerOptions>
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

.winstreak {
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