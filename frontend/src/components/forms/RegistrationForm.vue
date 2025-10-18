<script setup>
import { useRouter } from 'vue-router'
</script>

<template>
  <div class="container"></div>
  <form method="post">
    <label>
      Name:
      <input type="text" name="name" placeholder="Name">
    </label>
    <label>
      Email:
      <input type="text" name="name" placeholder="Email">
    </label>
    <label>
      Password:
      <input type="text" name="name" placeholder="Password">
    </label>
    <button type="submit">Зарегистрироваться</button>
  </form>
</template>

<style scoped>

.container {
  padding: 20px;
}
</style>