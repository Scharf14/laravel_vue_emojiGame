<script setup>
import {computed, ref} from 'vue'
import apiClient from "@/utils/api.js";


const props = defineProps({
  frameFilm: Number
})

</script>

<template>
  <div class="film-container">
    <div>
      <img :src="pathFilm">
    </div>
  </div>
</template>

<style scoped>

.film-container {
  margin-top: 200px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.film-container img {
  max-width: 350px;
  max-height: 525px;
  width: auto;
  height: auto;
  border-radius: 14px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
  object-fit: contain;
  border: 3px solid #68904D;
}

</style>