<template>
  <div>
    <h2>Edit Article</h2>
    <form @submit.prevent="submitEdit">
      <div>
        <label>Title:</label>
        <input v-model="title" required />
      </div>
      <div>
        <label>Body:</label>
        <textarea v-model="body" required></textarea>
      </div>
      <button type="submit">Save</button>
      <router-link to="/articles">Cancel</router-link>
    </form>
    <p v-if="message" :class="success ? 'success' : 'error'">{{ message }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { apiRequest } from '../api';

const route = useRoute();
const router = useRouter();

const title = ref('');
const body = ref('');
const message = ref('');
const success = ref(false);

onMounted(async () => {
    const { ok, data } = await apiRequest(`/articles/${route.params.id}`);
    if (ok) {
        title.value = data.title;
        body.value = data.body;
    }
});

const submitEdit = async () => {
    const { ok } = await apiRequest(`/articles/edit/${route.params.id}`, {
        method: 'PUT',
        body: JSON.stringify({ title: title.value, body: body.value }),
    }, true);

    if (ok) {
        router.push('/articles');
    } else {
        message.value = 'Failed to update article.';
        success.value = false;
    }
};
</script>

<style scoped>
.error { color: red; }
.success { color: green; }
</style>
