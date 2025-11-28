<script setup>
import {ref} from 'vue'

const props = defineProps({
  experience: Number
})
</script>

<template>
  <div class="win-container">
    <div>
      <p>Опыт: {{ props.experience }}</p>
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