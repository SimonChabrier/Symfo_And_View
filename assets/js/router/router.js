import { createRouter, createWebHashHistory } from 'vue-router'


import HomeView from '@view/HomeView.vue'
import RegisterView from '@view/RegisterView.vue'
import error404 from '@view/404.vue'
import UserView from '@view/UserView.vue'

const routes = [
  // Home page => voir la résolution des liens dans le controller HomeController de Symfony
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  // enregistrer un utilisateur en base de données
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
  // voir un utilisateur en base de données par son id
  {
    path: '/user/:id',
    name: 'user',
    component: UserView
    },

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