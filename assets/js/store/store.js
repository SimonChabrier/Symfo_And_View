import { createStore } from 'vuex'
import axios from 'axios'
import authServices from '@sevices/auth.service.js'

const API_ROOT_URL = 'https://127.0.0.1:8000/api/users'


export default createStore ({

  state: {
    count : '',
    deleteMessage: '',
    allUsers: [],
    user: {},
    searchUsers : [],
    loggedIn: false,
    adminName:'admin',
    errors: '',
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
      state.allUsers.push(user);
      state.user = user;
      
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
    catchErrors(state, errors) {
      state.errors = errors;
    },
    setLoggedIn(state, loggedIn) {
      state.loggedIn = loggedIn;
    }

    
  },

  // les actions permettent d'appeler des mutations de manière asynchrone
  actions: {
    
    // récupérer les utilisateur 
    // actuellement route API publique => pas besoin de token
    // mais si je veux la sécuriser le token est ici dans le header..
    async fetchUsers(context) {
      const headers = authServices.authenticateUser();
      
      try { await axios.get (API_ROOT_URL, { headers })
      .then(response => {
          if (response.status === 200) {
            context.commit('setUsers', response.data);
            context.commit('setCount', response.data.length);
            console.log(context.state.allUsers);
            // set loggedIn to true if token exists
              if(authServices.checkToken() === true){
                context.commit('setLoggedIn', true);
              } else {
                context.commit('setLoggedIn', false);
              }
          }
        });
      } catch (error) {
        if (error.response) {
          context.commit('catchErrors', `Erreur Code : ${error.response.data.status}`);
          // console.log(context.state.errors);
          // console.log(error.response.data);
          // console.log(error.response.status);
          // console.log(error.response.headers);
        }
      }
    },
 
    // fetch un user par son id
    // actuellement route API publique => pas besoin de token
    // mais si je veux la sécuriser le token est ici dans le header..
    async fetchUser(context, id) {
      const headers = authServices.authenticateUser();
      const response = (await axios.get (API_ROOT_URL + '/' + id, { headers })).data
      context.commit('setUser', response);
      console.log(context.state.user);
    },

    // delete un user par son id
    // actuellement route API sécurisée qui demande le Token
    async deleteUser(context, id) {
      const headers = authServices.authenticateUser();
      // supprime l'utilisateur de la base de données
      const response = (await axios.delete (API_ROOT_URL + '/delete/' + id, { headers })).data
      // met à jour le compteur de users ne enlevant 1
      context.commit('decrementCount');
      // retourne un message de confirmation
      console.log(response)
      context.commit('confirmDelete', `L'utilisateur ${response.username} a bien été supprimé`);
      // supprimer l'utilisateur supprimé si il est dans le tableau des résultats de recherche
      if(context.state.searchUsers.length > 0) {
        const results = context.state.searchUsers.filter(user => user.id !== id);
        context.commit('setSearchUsers', results);
      }
      // je refectche l'ensemble des users pour mettre à jour le tableau des users dans le state et garder à jour l'affichage de HomeView
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
    },

    logout(context) {
      authServices.killAuth();
      context.state.loggedIn = false;
    },

    login(context, user) {
      authServices.setAuth(user);
      context.state.loggedIn = true;
    }
  },

})

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
  //   actions: { ... },
  //   getters: { ... }
  // }
  
  // const store = createStore({
  //   modules: {
  //     a: moduleA,
  //     b: moduleB
  //   }
  // })
  
  // store.state.a // -> `moduleA`'s state
  // store.state.b // -> `moduleB`'s state