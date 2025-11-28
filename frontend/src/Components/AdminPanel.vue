<script setup>
import {ref, reactive} from 'vue'
import apiClient from "@/utils/api.js";

const showMovieForm = ref(false)

const newMovie = reactive({
  name: '',
  difficult_id: '',
  path_to_film: ''
})

const addMovie = () => {
  const data = new FormData()

  data.append('name', newMovie.name)
  data.append('difficult_id', newMovie.difficult_id)
  data.append('path_to_film', newMovie.path_to_film)

  console.log(newMovie.path_to_film.name)
  apiClient.post('/admin/film', newMovie, {
    headers: {
      "Content-Type": 'multipart/form-data'
    }
  })
      .then( function (response) {
        console.log('фильм добавлен', response.data)
      })
      .catch(response => console.log(response))
  newMovie.name = ''
  newMovie.difficult_id = ''
  newMovie.path_to_film = ''
  showMovieForm.value = false
}

const cancelAddMovie = () => {
  showMovieForm.value = false
  newMovie.name = ''
  newMovie.difficulty = ''
}

const handleFileUpload = (event) => {
  newMovie.path_to_film = event.target.files[0]
}
</script>

<template>
  <div class="admin-container">
    <div class="admin-card">
      <h2 class="title">Админ панель</h2>

      <div class="admin-content">
        <!-- Кнопка для открытия формы добавления фильма -->
        <button
            @click="showMovieForm = true"
            class="admin-button primary"
            v-if="!showMovieForm"
        >
          Добавить фильм
        </button>

        <!-- Форма добавления фильма -->
        <div v-if="showMovieForm" class="movie-form">
          <h3 class="form-title">Добавить новый фильм</h3>

          <form class="admin-form" @submit.prevent="addMovie">
            <div class="input-group">
              <label class="label">Название фильма</label>
              <input
                  v-model="newMovie.name"
                  type="text"
                  class="input"
                  placeholder="Введите название фильма"
                  required
              >
            </div>

            <div class="input-group">
              <label class="label">Сложность</label>
              <select
                  v-model="newMovie.difficult_id"
                  class="input"
                  required
              >
                <option value="">Выберите сложность</option>
                <option value="1">easy</option>
                <option value="2">medium</option>
                <option value="3">hard</option>
              </select>
            </div>
            <div class="input-group">
              <label class="label">Файл фильма</label>
              <input
                  type="file"
                  @change="handleFileUpload"
                  class="input"
                  required
              >
            </div>
            <div class="form-buttons">
              <button type="submit" class="admin-button primary">
                Добавить фильм
              </button>
              <button
                  type="button"
                  @click="cancelAddMovie"
                  class="admin-button secondary"
              >
                Отмена
              </button>
            </div>
          </form>
        </div>

        <!-- Контейнер для будущих кнопок -->
        <div class="buttons-container" v-if="!showMovieForm">
          <!-- Будущие кнопки можно будет добавлять сюда -->
          <!--
          <button class="admin-button secondary">
            Управление фильмами
          </button>
          <button class="admin-button secondary">
            Статистика
          </button>
          <button class="admin-button danger">
            Настройки
          </button>
          -->
        </div>

        <!-- Дополнительный контейнер для группировки будущих кнопок -->
        <div class="action-groups" v-if="!showMovieForm">
          <!-- Будущие группы действий -->
          <!--
          <div class="action-group">
            <h3 class="group-title">Управление контентом</h3>
            <button class="admin-button secondary">Все фильмы</button>
            <button class="admin-button secondary">Категории</button>
          </div>
          -->
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.admin-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  background: #f8f9fa;
}

.admin-card {
  background: white;
  padding: 2.5rem;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 500px;
}

.title {
  text-align: center;
  color: #333;
  margin-bottom: 2rem;
  font-size: 1.5rem;
  font-weight: 600;
}

.admin-content {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.movie-form {
  background: #f8f9fa;
  padding: 1.5rem;
  border-radius: 8px;
  border: 2px solid #e1e5e9;
}

.form-title {
  color: #333;
  margin-bottom: 1.5rem;
  font-size: 1.2rem;
  font-weight: 600;
  text-align: center;
}

.admin-form {
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
  background-color: white;
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

.form-buttons {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}

.form-buttons .admin-button {
  flex: 1;
}

.buttons-container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  min-height: 60px;
}

.action-groups {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  margin-top: 1rem;
}

.action-group {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
}

.group-title {
  color: #555;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  border-bottom: 1px solid #e1e5e9;
  padding-bottom: 0.5rem;
}

.admin-button {
  border: none;
  padding: 0.875rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  text-align: center;
  width: 100%;
}

.admin-button.primary {
  background: #EE9B01;
  color: white;
}

.admin-button.secondary {
  background: #6c757d;
  color: white;
}

.admin-button.danger {
  background: #dc3545;
  color: white;
}

.admin-button.success {
  background: #28a745;
  color: white;
}

.admin-button.info {
  background: #17a2b8;
  color: white;
}

.admin-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.admin-button:active {
  transform: translateY(0);
}

/* Адаптивность */
@media (max-width: 768px) {
  .admin-card {
    padding: 2rem;
    margin: 1rem;
  }

  .admin-button {
    padding: 0.75rem;
    font-size: 0.9rem;
  }

  .form-buttons {
    flex-direction: column;
  }
}

/* Анимации */
.buttons-container > * {
  animation: fadeIn 0.3s ease-in;
}

.movie-form {
  animation: slideDown 0.3s ease-out;
}

@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(10px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes slideDown {
  from {
    opacity: 0;
    transform: translateY(-20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>