import { createStore } from 'vuex'
import axios from 'axios'

const API_ROOT_URL = 'https://127.0.0.1:8000/api/users'

export default createStore ({
  state: {
    count : '',
    deleteMessage: '',
    allUsers: [],
    user: {},
    searchUsers : []
  },

  // les getters permettent de récupérer des données du state dans son contexte et son état actuel
  getters: {
    getUsers(state) {
      return state.allUsers;
    },
    getUser(state) {
      return state.user;
    }
  },

  // les mutations permettent de modifier le state de manière synchrone
  mutations: {

    // Gestion des users
    setUsers(state, allUsers) {
      state.allUsers = allUsers;
    },
    setUser(state, user) {
      state.user = user;
      state.allUsers.push(user);
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
    
    // fecth l'ensemble des users en BDD
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
      // supprime l'utilisateur de la base de données
      const response = (await axios.delete (API_ROOT_URL + '/' + id)).data
      // supprime l'utilisateur supprimé du state
      context.commit('setUser', response);
      // met à jour le compteur de users ne enlevant 1
      context.commit('decrementCount');
      // retourne un message de confirmation
      context.commit('confirmDelete', `L'utilisateur ${response.username} a bien été supprimé`);
      // supprimer l'utilisateur supprimé si il est dans le tableau des résultats de recherche
      const searchUsers = context.state.searchUsers.filter(user => user.id !== id);
      context.commit('setSearchUsers', searchUsers);
      // met à jour le tableau des users
      context.dispatch('fetchUsers');
    },

    // enregistrer un nouveau user
    async registerUser(context, user) {
      const response = (await axios.post (API_ROOT_URL + '/register', user)).data
      context.commit('setUser', response);
      context.commit('incrementCount');
    },
    // cherche dans le tableau des users
    searchUser(context, search) {
      if(search.length > 0) {
      const results = context.state.allUsers.filter(user => user.username.toLowerCase().includes(search.toLowerCase()));
      context.commit('setSearchUsers', results);
      } else {
        const results = '';
        context.commit('setSearchUsers', results);
      }
    }

   
  },

  // les modules permettent de découper le store en plusieurs parties
  // https://vuex.vuejs.org/guide/modules.html

  // const moduleA = {
  //   state: () => ({ ... }),
  //   mutations: { ... },
  //   actions: { ... },
  //   getters: { ... }
  // }
  
  // const moduleB = {
  //   state: () => ({ ... }),
  //   mutations: { ... },
  //   actions: { ... }
  // }
  
  // const store = createStore({
  //   modules: {
  //     a: moduleA,
  //     b: moduleB
  //   }
  // })
  
  // store.state.a // -> `moduleA`'s state
  // store.state.b // -> `moduleB`'s state

})