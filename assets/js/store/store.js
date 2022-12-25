import { createStore } from 'vuex'
import axios from 'axios'

const API_ROOT_URL = 'https://127.0.0.1:8000/api/users'

export default createStore ({
  state: {
    users: [],
    user: {},
  },

  // les getters permettent de récupérer des données du state dans son contexte et son état actuel
  getters: {
    getUsers(state) {
      return state.users;
    },
    getUser(state) {
      return state.user;
    }
  },

  // les mutations permettent de modifier le state de manière synchrone
  mutations: {
    setUsers(state, users) {
      state.users = users;
    },
    setUser(state, user) {
      state.user = user;
    }
  },

  // les actions permettent d'appeler des mutations de manière asynchrone
  actions: {
    
    // fecth tout les users
    async fetchUsers(context) {
      const response = (await axios.get (API_ROOT_URL)).data
      context.commit('setUsers', response);
    },
    // fetch un user par son id
    async fetchUser(context, id) {
      const response = (await axios.get (API_ROOT_URL + '/' + id)).data
      context.commit('setUser', response);
    },
    // delete un user par son id
    async deleteUser(context, id) {
      const response = (await axios.delete (API_ROOT_URL + '/' + id)).data
      context.commit('setUser', response);
    },
    async registerUser(context, user) {
      const response = (await axios.post (API_ROOT_URL + '/register', user)).data
      context.commit('setUser', response);
    }
   
  },

  // les modules permettent de découper le store en plusieurs fichiers
  modules: {
    // module1: module1,
  },

})