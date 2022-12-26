import { createStore } from 'vuex'
import axios from 'axios'

const API_ROOT_URL = 'https://127.0.0.1:8000/api/users'

export default createStore ({
  state: {
    count : '',
    deleteMessage: '',
    users: [],
    user: {},
    searchUsers : []
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

    // Gestion des users
    setUsers(state, users) {
      state.users = users;
    },
    setUser(state, user) {
      state.user = user;
      state.users.push(user);
    },
    setSearchUsers(state, results) {
      state.searchUsers = results;
    },

    confirmDelete(state, message) {
      state.deleteMessage = message;
    },

    // Gestion du compteur de users
    setCount(state, count) {
      state.count = count;
    },
    decrementCount(state) {
      state.count = state.count - 1;
    },
    incrementCount(state) {
      state.count = state.count + 1;
    },

    
  },

  // les actions permettent d'appeler des mutations de manière asynchrone
  actions: {
    
    // fecth tout les users
    async fetchUsers(context) {
      const response = (await axios.get (API_ROOT_URL)).data
      context.commit('setUsers', response);
      context.commit('setCount', response.length);
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
      context.commit('decrementCount');
      context.commit('confirmDelete', `L'utilisateur ${response.username} a bien été supprimé`);
    },

    // retirer chaque user supprimé du tableau users pour garder la liste à jour dans le composant HomeView
    removeDeletedUserFromUsers(context, id) {
      const users = context.state.users.filter(user => user.id !== id);
      context.commit('setUsers', users);
    },
    // enregistrer un nouveau user
    async registerUser(context, user) {
      const response = (await axios.post (API_ROOT_URL + '/register', user)).data
      context.commit('setUser', response);
      context.commit('incrementCount');
    },
    
    searchUser(context, search) {

      if(search.length > 3) {
      const results = context.state.users.filter(user => user.username.toLowerCase().includes(search.toLowerCase()));
      context.commit('setSearchUsers', results);
      } else {
        const results = '';
        context.commit('setSearchUsers', results);
      }
    }

   
  },

  // les modules permettent de découper le store en plusieurs fichiers
  modules: {
    // module1: module1,
  },

})