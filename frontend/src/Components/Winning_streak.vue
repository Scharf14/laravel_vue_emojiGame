<script setup>
import {computed, ref} from 'vue'

const props = defineProps({
  experience: Number
})

const stats = computed(() => {
  return props.experience
})
</script>

<template>
  <div class="win-container">
    <div>
      <p>Experience: {{ stats }}</p>
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