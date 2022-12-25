import { createRouter, createWebHashHistory } from 'vue-router'

import App from '../../App.vue'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
//   {
//     path: '/user/:id',
//     name: 'user',
//     component: RecipeView
//     },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router