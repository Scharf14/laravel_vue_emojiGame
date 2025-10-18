<script setup>
import {ref} from 'vue'

const props = defineProps({
  lvlGame: Number
})

</script>

<template>
  <div class="levelContainer">
    <div>
      <p>Уровень: {{ lvlGame }}</p>
    </div>
  </div>
</template>

<style scoped>
.levelContainer {
  margin-top: 100px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: cadetblue;
}

</style>
