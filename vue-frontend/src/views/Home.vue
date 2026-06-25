<template>
  <div class="articles">
    <h2>Articles</h2>
    <p v-if="error" class="error">{{ error }}</p>
    <ul v-if="articles.length">
      <li v-for="article in articles" :key="article.id">
        <div class="article-header">
          <strong>{{ article.title }}</strong>
          <div class="actions">
            <router-link :to="`/edit/${article.id}`">Edit</router-link>
            <button @click="deleteArticle(article.id)">Delete</button>
          </div>
        </div>
        <p>{{ article.body }}</p>
      </li>
    </ul>
    <p v-else-if="!error">No articles yet.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { apiRequest } from '../api';

const articles = ref([]);
const error = ref('');

onMounted(async () => {
    const { ok, data } = await apiRequest('/articles');
    if (ok) {
        articles.value = data;
    } else {
        error.value = 'Failed to load articles.';
    }
});

const deleteArticle = async (id) => {
    if (!confirm('Delete this article?')) return;

    const { ok } = await apiRequest(`/articles/delete/${id}`, { method: 'DELETE' }, true);
    if (ok) {
        articles.value = articles.value.filter(a => a.id !== id);
    } else {
        error.value = 'Failed to delete article.';
    }
};
</script>

<style scoped>
.articles {
    max-width: 600px;
    margin: auto;
}
.article-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.actions {
    display: flex;
    gap: 8px;
}
.error {
    color: red;
}
</style>
