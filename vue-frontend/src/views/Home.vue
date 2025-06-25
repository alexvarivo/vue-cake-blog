<template>
  <div>
    <h1>Articles</h1>
    <ul>
      <li v-for="article in articles" :key="article.id">
        <strong>{{ article.title }}</strong><br />
        {{ article.body }}<br />
        <button @click="deleteArticle(article.id)">Delete</button>
      </li>
      <p v-if="message" style="color: green">{{ message }}</p>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const articles = ref([]);
const message = ref('');

const fetchArticles = async () => {
  try {
    const token = localStorage.getItem('token');
    const response = await fetch('http://localhost:8081/articles', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    if (response.ok) {
      const data = await response.json();
      articles.value = data;
    } else {
      console.error('Failed to fetch articles.');
    }
  } catch (error) {
    console.error('Error fetching articles:', error);
  }
};

const deleteArticle = async (id) => {
  if (!confirm('Are you sure you want to delete this article?')) return;

  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`http://localhost:8081/articles/delete/${id}`, {
      method: 'DELETE',
      headers: {
        Authorization: `Bearer ${token}`
      }
    });

    if (res.ok) {
      // remove deleted article from the list
      articles.value = articles.value.filter(a => a.id !== id);
      message.value = 'Article deleted successfully!';
      setTimeout(() => {
        message.value = '';
    }, 3000); // clear after 3 seconds
    } else {
      console.error('Delete failed');
    }
  } catch (err) {
    console.error('Error deleting article:', err);
  }
};

onMounted(fetchArticles);
</script>
