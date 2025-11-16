<script setup>
import {ref} from 'vue'

</script>

<template>
  <div class="win-container">
    <div>
      <p>Опыт: {{ winStreak }}</p>
    </div>
  </div>
</template>

<style scoped>
.win-container {
  margin-top: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: cadetblue;
}

</style>