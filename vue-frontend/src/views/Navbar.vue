<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/add">Add Article</router-link> |
    <button @click="$emit('logout')">Logout</button>
  </nav>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

function logout() {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>

<style scoped>
nav {
  display: flex;
  gap: 1rem;
  padding: 1rem;
  background-color: #f5f5f5;
  border-bottom: 1px solid #ddd;
}
button {
  cursor: pointer;
}
</style>
