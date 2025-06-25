import { createRouter, createWebHistory } from 'vue-router'
import Login from '../views/Login.vue'
import Home from '../views/Home.vue'
import AddArticle from '../views/AddArticle.vue'
import ViewArticle from '../views/ViewArticle.vue'

const routes = [
  { path: '/login', name: 'Login', component: Login },
  {
    path: '/',
    name: 'Home',
    component: Home,
    meta: { requiresAuth: true },
  },
  {
    path: '/articles',
    name: 'Articles',
    component: () => import('../views/Articles.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/add',
    name: 'AddArticle',
    component: AddArticle,
    meta: { requiresAuth: true },
  },
  {
    path: '/view/:id',
    name: 'ViewArticle',
    component: ViewArticle,
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

// Global navigation guard
router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token')

  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login')
  } else {
    next()
  }
})

export default router
