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
    <p v-if="message" :style="{ color: messageColor }">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue';

const title = ref('');
const body = ref('');
const message = ref('');
const messageColor = ref('green');

const submitArticle = async () => {
  try {
    const token = localStorage.getItem('token');
    console.log("Sending token:", token);

    const response = await fetch('http://localhost:8081/articles/add', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`,
      },
      body: JSON.stringify({ title: title.value, body: body.value }),
    });

    const data = await response.text(); // can be HTML or JSON

    if (response.ok) {
      message.value = 'Article submitted successfully!';
      setTimeout(() => {
        message.value = '';
    }, 3000); // Clear after 3 seconds
      messageColor.value = 'green';
      title.value = '';
      body.value = '';
    } else {
      message.value = `Failed to submit article: ${data}`;
      messageColor.value = 'red';
    }
  } catch (error) {
    console.error('Error submitting article:', error);
    message.value = 'Network or server error.';
    messageColor.value = 'red';
  }
};
</script>
