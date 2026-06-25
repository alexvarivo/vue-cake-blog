<template>
  <div>
    <h2>Add Article</h2>
    <form @submit.prevent="submitArticle">
      <div>
        <label>Title:</label>
        <input v-model="title" required />
      </div>
      <div>
        <label>Body:</label>
        <textarea v-model="body" required></textarea>
      </div>
      <button type="submit">Submit</button>
    </form>
    <p v-if="message" :class="success ? 'success' : 'error'">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { apiRequest } from '../api';

const title = ref('');
const body = ref('');
const message = ref('');
const success = ref(false);

const submitArticle = async () => {
    message.value = '';
    const { ok, data } = await apiRequest('/articles/add', {
        method: 'POST',
        body: JSON.stringify({ title: title.value, body: body.value }),
    }, true);

    if (ok) {
        success.value = true;
        message.value = 'Article submitted successfully!';
        title.value = '';
        body.value = '';
        setTimeout(() => { message.value = ''; }, 3000);
    } else {
        success.value = false;
        message.value = data.error || 'Failed to submit article.';
    }
};
</script>

<style scoped>
.error { color: red; }
.success { color: green; }
</style>
