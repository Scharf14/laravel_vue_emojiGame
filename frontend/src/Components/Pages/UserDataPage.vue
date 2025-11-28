<script setup>
import Layout from "@/Components/Layout.vue";
import {computed, onMounted, reactive, ref} from "vue";
import apiClient from "@/utils/api.js";
import router from "@/router.js";

let avatar = ref('')
let user = ref({})
let stats = ref({
  level: 1,
  winstreak: 0,
  experience: 0
})


function getData() {
  apiClient.get('http://localhost:8000/api/profile/show')
      .then(response => {
        stats.value = response.data.stats
        user.value = response.data.user
      }).catch(response => {
    console.log(response)
  })
}

function goBack() {
  router.go(-1) // изменить на router-link
}

onMounted(() => {
  getData()
})


</script>

<template>
  <Layout
      :level="stats.level"
      :experience="stats.experience"
      :winstreak="stats.winstreak"
      :avatarPath="avatar"
  >
    <div class="user-profile-modal">
      <div class="user-card">
        <button @click="goBack" class="close-btn">x</button>

        <div class="avatar-wrapper">
          <img src="#" alt="Аватар" class="avatar-img"/>
        </div>

        <div class="user-info">
          <h3 class="user-name">{{ user.name }}</h3>
          <p class="user-email">{{ user.email }}</p>

          <div class="level-exp">
            <div class="level-row">
              <span class="level-label">Уровень</span>
              <span class="level-value">{{ stats.level }}</span>
            </div>

            <div class="exp-bar-container">
              <div class="exp-bar">
                <div
                    class="exp-fill"
                    :style="{}">

                </div>
              </div>
              <span class="exp-text">{{ stats.experience }} EXP</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>

</template>

<style scoped>

.close-btn {
  width: 20px;
  height: 20px;
  border-radius: 5px;
}

.close-icon {
  color: black;
  text-decoration: none;
}

.user-profile-modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  padding: 20px;
  box-sizing: border-box;
}

.user-card {
  display: flex;
  align-items: center;
  gap: 20px;
  padding: 24px;
  background: linear-gradient(135deg, #68904d 0%, #5f9ea0 100%);
  border-radius: 24px;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.25);
  max-width: 420px;
  width: 100%;
  color: white;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  border: 3px solid rgba(255, 255, 255, 0.15);
}

.avatar-wrapper {
  flex-shrink: 0;
}

.avatar-img {
  width: 90px;
  height: 90px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid #ee9b01;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.user-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.user-name {
  margin: 0;
  font-size: 1.5rem;
  font-weight: 600;
  color: #fff;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.user-email {
  margin: 0;
  font-size: 1rem;
  opacity: 0.9;
  color: #f0f8ff;
}

.level-exp {
  margin-top: 8px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.level-row {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.level-label {
  font-size: 0.95rem;
  opacity: 0.9;
}

.level-value {
  font-size: 1.3rem;
  font-weight: 700;
  color: #ee9b01;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
}

.exp-bar-container {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 0.9rem;
}

.exp-bar {
  flex: 1;
  height: 10px;
  background-color: rgba(255, 255, 255, 0.25);
  border-radius: 5px;
  overflow: hidden;
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
}

.exp-fill {
  height: 100%;
  background-color: #ee9b01;
  border-radius: 5px;
  transition: width 0.5s ease;
  box-shadow: 0 0 8px rgba(238, 155, 1, 0.4);
}

.exp-text {
  min-width: 70px;
  text-align: right;
  font-weight: 500;
  color: #ee9b01;
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
}


</style>