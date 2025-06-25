<script setup>
import { ref, watchEffect } from 'vue'
import { useRouter } from 'vue-router'
import Navbar from './views/Navbar.vue'

const router = useRouter()
const isLoggedIn = ref(!!localStorage.getItem('token'))

const logout = () => {
  localStorage.removeItem('token')
  isLoggedIn.value = false
  router.push('/login')
}

watchEffect(() => {
  if (!localStorage.getItem('token')) {
    isLoggedIn.value = false
    router.push('/login')
  }
})
</script>

<template>
  <div>
    <Navbar v-if="isLoggedIn" @logout="logout" />
    <router-view @logged-in="isLoggedIn = true" />
  </div>
</template>

<style>
body {
  background-color: #71a6c2;
  font-family: Arial, sans-serif;
}
</style>

<style scoped>
.container {
  max-width: 400px;
  margin: auto;
  text-align: center;
}

.input-container {
  display: flex;
  gap: 10px;
  margin-bottom: 20px;
}

input {
  flex: 1;
  padding: 8px;
  background-color: #d4d3c9;
  border: 1px solid #ccc;
  border-radius: 4px;
  color: #333;
}

button {
  padding: 8px 12px;
  cursor: pointer;
  background-color: #d4d3c9;
  border: 1px solid #ccc;
  border-radius: 4px;
}

ul {
  list-style: none;
  padding: 0;
}

li {
  display: flex;
  justify-content: space-between;
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.completed {
  text-decoration: line-through;
  color: #555;
}

li span {
  font-weight: bold;
}
</style>
