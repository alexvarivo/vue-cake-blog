<template>
  <div class="login">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <input v-model="username" type="text" placeholder="Username" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { apiRequest } from '../api';

const emit = defineEmits(['logged-in']);
const router = useRouter();

const username = ref('');
const password = ref('');
const error = ref('');

const handleLogin = async () => {
    error.value = '';
    const { ok, data } = await apiRequest('/users/login', {
        method: 'POST',
        body: JSON.stringify({ username: username.value, password: password.value }),
    });

    if (ok) {
        localStorage.setItem('token', data.token);
        emit('logged-in');
        router.push('/');
    } else {
        error.value = data.error || 'Login failed';
    }
};
</script>

<style scoped>
.login {
    max-width: 400px;
    margin: 60px auto;
}
.error {
    color: red;
}
</style>
