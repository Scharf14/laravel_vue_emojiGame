<script setup>
import {computed, ref} from 'vue'

const props = defineProps({
  level: Number
})

</script>

<template>
  <div class="levelContainer">
    <div>
      <p> Level: {{props.level}}</p>
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
