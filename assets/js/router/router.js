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
  // on laisse le paramètre id optionnel :id? pour pouvoir afficher un message d'erreur si l'id n'est pas trouvé
  // et pour ne pas avoir d'erreur sur les redirection si on delete un user car il n'y a plus d'id dans l'url...
  {
    path: '/user/:id?',
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