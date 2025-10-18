<script setup>
import {ref} from 'vue'


const props = defineProps({
  emoji: String
})


</script>

<template>
  <div class="emoji-container">
    <div>
      <p class="emoji">{{ emoji }}</p>
    </div>
  </div>
</template>

<style scoped>

.emoji-container {
  margin-top: 200px;
  display: flex;
  justify-content: center;
}

.emoji {
  font-size: 40px;
  letter-spacing: 20px;
}

</style>