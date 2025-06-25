<template>
  <div class="login">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <input v-model="username" type="text" placeholder="Username" required />
      <input v-model="password" type="password" placeholder="Password" required />
      <button type="submit">Login</button>
    </form>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: '',
      password: '',
      error: '',
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await fetch('http://localhost:8081/users/login', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
        });

        const data = await response.json();

        if (!response.ok) {
          this.error = data.error || 'Login failed';
          return;
        }

        localStorage.setItem('token', data.token);
        this.$emit('logged-in'); 
        this.$router.push('/');
      } catch (err) {
        this.error = 'Something went wrong';
        console.error(err);
      }
    },
  },
};
</script>
