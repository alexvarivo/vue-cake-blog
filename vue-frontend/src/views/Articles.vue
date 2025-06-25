<template>
  <div class="articles">
    <h2>All Articles</h2>
    <ul>
      <li v-for="article in articles" :key="article.id">
        <h3>{{ article.title }}</h3>
        <p>{{ article.body }}</p>
      </li>
    </ul>
    <p v-if="error" style="color: red">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const articles = ref([]);
const error = ref('');

onMounted(async () => {
  try {
    const res = await fetch('http://localhost:8081/articles.json');
    const data = await res.json();
    articles.value = data;
  } catch (err) {
    error.value = 'Failed to load articles.';
    console.error(err);
  }
});
</script>

<style scoped>
.articles {
  max-width: 600px;
  margin: auto;
}
h3 {
  margin-bottom: 0;
}
p {
  margin-top: 0;
}
</style>