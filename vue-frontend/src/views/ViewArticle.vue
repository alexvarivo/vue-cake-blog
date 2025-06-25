<template>
  <div>
    <h2>Articles</h2>
    <ul>
      <li v-for="article in articles" :key="article.id">
        <h3>{{ article.title }}</h3>
        <p>{{ article.body }}</p>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const articles = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('http://localhost:8081/articles');
    const data = await response.json();
    articles.value = data;
  } catch (error) {
    console.error('Failed to fetch articles:', error);
  }
});
</script>
