import { createStore } from 'vuex'
import axios from 'axios'

const API_ROOT_URL = 'https://127.0.0.1:8000/api/users'

export default createStore ({
  state: {
    users: [],
  },

  // les getters permettent de récupérer des données du state
  getters: {
    getUsers(state) {
      return state.users;
    },
  },

  // les mutations permettent de modifier le state
  mutations: {
    setUsers(state, users) {
      state.users = users;
    },
  },

  // les actions permettent d'appeler des mutations
  actions: {
    async fetchUsers(context) {
      const response = (await axios.get (API_ROOT_URL)).data
      context.commit('setUsers', response);
    },

  },

  // les modules permettent de découper le store en plusieurs fichiers
  modules: {
  },

})