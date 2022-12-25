import { createRouter, createWebHashHistory } from 'vue-router'


import HomeView from '@view/HomeView.vue'
import RegisterView from '@view/RegisterView.vue'
import error404 from '@view/404.vue'

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

 //404 page
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: error404
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router