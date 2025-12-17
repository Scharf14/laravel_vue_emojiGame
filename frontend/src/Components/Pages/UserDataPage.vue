<script setup>
import Layout from "@/Components/Layout.vue";
import {computed, onMounted, inject, ref} from "vue";
import apiClient from "@/utils/api.js";

const user = ref({
  name: '',
  email: '',
})

const stats = JSON.parse(localStorage.getItem('stat'))
const userLocal = JSON.parse(localStorage.getItem('user'))
const filePath = ref(null)
const avatar = ref(null)

if (!avatar.value) {
  avatar.value = '../../public/face.jpeg'
}

function setAvatar() {
  const data = new FormData()
  data.append('path_to_avatar', avatar.value)
  console.log('Файл для отправки:', avatar.value)
  console.log('Имя файла:', avatar.value.name)
  console.log('Размер:', avatar.value.size, 'байт')

  apiClient.post('/profile/setAvatar', data, {
        headers: {
          "Content-Type": 'multipart/form-data'
        }
      }
  )
      .then(response => {
        console.log('Ответ setAvatar')
        getAvatar()
      })
      .catch(e => {
        console.log(e)
      })
}

function getAvatar() {
  apiClient.get('/profile/getAvatar', {
    responseType: 'blob',
    headers: {
      'Cache-control': 'no-cache'
    }
  })
      .then(response => {
        avatar.value = URL.createObjectURL(response.data)
      })
      .catch(e => {
        console.log('loadAvatar', e)
      })
}

onMounted(() => {
  getAvatar()
})

function handleFileUpload(event) {
  avatar.value = event.target.files[0]
}


</script>

<template>
  <Layout
      :avatar="avatar"
  >
    <div class="container-profile">
      <div class="title">
        <span>Player profile</span>
      </div>
      <div class="profile-content">
        <div class="avatar-section">
          <div class="avatar">
            <img :src="avatar" alt="">
          </div>
        </div>
        <div class="profile-section">
          <div class="data-name">Name: {{ }}</div>
          <div class="data-email">Mail: {{ l }}</div>
          <div class="send-data-avatar">
            <input type="file" id="avatar-input" @change="handleFileUpload">
            <label for="avatar-input" class="custom-file-btn">Take image</label>
            <button type="submit" class="submit-btn" @click="setAvatar">Send</button>
          </div>
        </div>
      </div>
      <div class="game-data">
        <div class="game-item">Experience: {{ stats.experience }}</div>
        <div class="game-item">Level: {{ stats.level }}</div>
        <div class="game-item">Winning streak: {{ stats.level }}</div>
      </div>
    </div>
  </Layout>

</template>

<style scoped>
.container-profile {
  background: white;
  border-radius: 12px;
  padding: 24px;
  max-width: 420px;
  min-width: 380px;
  margin: 20px auto;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #eaeaea;
  transition: padding 0.2s ease;
}

.title {
  text-align: center;
  margin-bottom: 24px;
  padding-bottom: 12px;
  border-bottom: 2px solid #f0f0f0;
}

.title span {
  font-size: 22px;
  font-weight: 600;
  color: #2d2d2d;
  letter-spacing: 0.5px;
}

.profile-content {
  display: flex;
  align-items: flex-start;
  gap: 20px;
  margin-bottom: 24px;
}

.avatar-section {
  flex-shrink: 0;
}

.avatar {
  width: 100px;
  height: 100px;
  border-radius: 8px;
  background: linear-gradient(135deg, #f5f5f5, #e8e8e8);
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border: 2px solid #f0f0f0;
}

.avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

.profile-section {
  display: flex;
  flex-direction: column;
  gap: 8px;
  flex-grow: 1;
}

.data-name {
  font-size: 20px;
  font-weight: 600;
  color: #1a1a1a;
  line-height: 1.3;
}

.data-email {
  font-size: 14px;
  color: #666;
  background: #f9f9f9;
  padding: 6px 10px;
  border-radius: 6px;
  border-left: 3px solid #d0d0d0;
}

.game-data {
  padding-top: 20px;
  border-top: 1px solid #f0f0f0;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
  gap: 12px;
}

.game-data * {
  font-size: 16px;
  font-weight: 500;
  color: #333;
  padding: 10px;
  text-align: center;
  border-radius: 6px;
  border: 1px solid #e0e0e0;
  background: transparent;
  min-height: 44px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.send-data-avatar {
  display: inline-block;
}

.send-data-avatar input[type="file"] {
  display: none; /* Прячем стандартный input */
}

.custom-file-btn {
  display: inline-block;
  background-color: #68904d; /* Зеленый */
  color: white;
  padding: 10px 20px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.2s;
}

.custom-file-btn:hover {
  background-color: #446b28; /* Темнее зеленый */
}

.submit-btn {
  display: inline-block;
  background-color: #fff; /* Зеленый */
  color: black;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  margin-left: 25px;
}
</style>
