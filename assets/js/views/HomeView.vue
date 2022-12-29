<template>
    <div class="homeView">

        <!-- Bloc Search input  -->
        <div class="search">
            <input type="text" placeholder="Rechercher un utilisateur" v-model="search" @input="getSearchDatas">
        </div>

        <!-- Bloc Search results  -->

        <Transition duration="550" name="nested">
            <div class="results" v-if="$store.state.searchUsers.length">
                <div class="item" v-for="user in $store.state.searchUsers" :key="user.id">
                    <!-- router link pour lier chaque user à son profil -->
                    <router-link :to="{ name: 'user', params: { id: user.id }}">
                        {{ user.username }}
                    </router-link>
                        
                    <button aria-label='delete user' v-if="user.username != $store.state.adminName" 
                        @click = "deleteUser(user.id)" 
                        type='button'> X
                    </button>
                </div>
            </div>
        </Transition>

        <!-- Bloc Login Form component -->

        <div>
            <LoginFormComponent />
        </div>

        <!-- Bloc delete confirmation message -->

        <Transition duration="550" name="nested">
            <div class="deleteMessage" v-if="$store.state.deleteMessage">
                <button class="close" aria-label='close message' v-if="user.username != $store.state.adminName" 
                    @click = "closeDeleteMessage()" 
                    type='button'> X
                </button>
                <span>
                    {{ $store.state.deleteMessage }}
                </span>
            </div>
        </Transition>

        <!-- Bloc user created message -->

        <Transition duration="550" name="nested">
            <div class="lastUser" v-if="$store.state.user.username">
                <button class="close" aria-label='close message'
                    @click = "closeNewUserCreatedMessage(event)" 
                    type='button'> X
                </button>
                <span>
                    Dernier utilisateur inscrit : {{ $store.state.user.username }}
                </span>
            </div>
        </Transition>

        <!-- Bloc user list  -->

         <!-- erros message on fetch  -->

         <div class="errors" v-if="$store.state.errors">
            <span>{{ $store.state.errors }}</span>
        </div>

        <!-- user list  -->
        <div class="usersList" v-else>

            <h1 class="title">{{ $store.state.count > 1 ? `${$store.state.count} utilisateurs enregistrés` : `${$store.state.count} utilisateur enregistré` }}</h1>

            <div class="userItem" v-if="$store.state.allUsers.length > 0">
                <TransitionGroup name="list" tag="ul">
                    <li v-for="user in $store.state.allUsers" :key="user.id">
                        
                            <button v-if="user.username != $store.state.adminName && $store.state.loggedIn === true" aria-label='delete user item' 
                                @click = " deleteUser(user.id) " 
                                type='button'> X
                            </button>
                    
                            <router-link :to="{ name: 'user', params: { id: user.id }}">
                                {{ user.username }} 
                            </router-link>
                        
                    </li>
                </TransitionGroup>
            </div>
        </div>

        <!-- Bloc inscription  -->

        <div class="register" @submit.prevent="register">
                
            <div class="title">
                <h1>Inscription</h1>
            </div>

            <form class= "registerForm">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" placeholder="Username" v-model="username">
                
                <label for="email">Email</label>
                <input type="email" placeholder="Email" v-model="email">
                
                <label for="password">Mot de passe</label>
                <input type="password" placeholder="Password" v-model="password">

                <label for="confirmPassword">Confirmer le mot de passe</label>
                <input type="password" placeholder="Confirm Password" v-model="confirmPassword">
                
                <button-component 
                    @click="''" 
                    :text="'inscription'" 
                    :color="'red'">
                </button-component>
            </form>
        </div>  
    </div>
</template>

<script>

/////////////////// import des composants ///////////////////

// import axios from 'axios';
import ButtonComponent from '@comp/elements/ButtonComponent.vue'
import LoginFormComponent from '@comp/LoginFormComponent.vue'
// import AuthService from '@sevices/auth.service.js'

/////////////////// export du composant ///////////////////

export default {

    name: 'HomeView',

    components: {
        ButtonComponent,
        LoginFormComponent,
    },

 /////////////////// state local ///////////////////

    data () {
        return {
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
            search: '',
        }
    },
    /////////////////// méthodes ///////////////////

    methods : {
        register () { 
            this.$store.dispatch('registerUser', this.getFormDatas)
            setTimeout(() => {
                this.$store.dispatch('fetchUsers')
            }, 100);

            this.resetForm()
            // this.lastUser = this.$store.state.user;
            // console.log(this.lastUser)
        },
        deleteUser (id) { 
            this.$store.dispatch('deleteUser', id)
        },
        resetForm () { 
            this.username = ''; 
            this.email = ''; 
            this.password = ''; 
        },
        closeDeleteMessage () { 
            this.$store.state.deleteMessage = false
        },
        closeNewUserCreatedMessage () { 
            this.$store.state.user = false
        },
    },
   
    /////////////////// computed ///////////////////

    computed : {
        getFormDatas () { 
            return { username: this.username, email: this.email, password: this.password, confirmPassword: this.confirmPassword } 
        },
        getSearchDatas () { 
            this.$store.dispatch('searchUser', this.search)
        },

    },
    
    /////////////////// lifecycle hooks dans l'ordre d'exécution  ///////////////////


    beforeCreate () {
        // console.log('beforeCreate')
    },
    created () {
        // console.log('created')
    },
    beforeMount () {
        // console.log('beforeMount')
    },
    // appelé à l'initialisation du composant
    mounted () {
        // console.log('mounted')
        document.title = "Accueil";
        this.$store.dispatch('fetchUsers')
    },
    beforeUpdate () {
        //console.log('beforeUpdate')
        
    },
    // appelé à chaque action sur le composant
    updated () {
        // console.log('updated') 
    },
    beforeDestroy () {
        // console.log('beforeDestroy')
    },
    destroyed () {
        // console.log('destroyed') 
    },

}

</script>

<style lang="scss" scoped>
.errors {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: $red;
    margin-bottom: $gutter-big;

    & span {
        font-size: 1.5rem;
        color: $lightWhite;
        margin-top: $gutter-big;
        margin-bottom: $gutter-big;
    }
}

.usersList {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.5rem;
    background-color: $mediumBlue;

    & .title {
        font-size: 1.5rem;
        color: $lightWhite;
        margin-top: $gutter-big;
        margin-bottom: $gutter-big;
    }

    & ul, li {
        list-style: none;
        color: $lightWhite;
        line-height: $gutter-big;
    }
}

.userItem {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    gap: 10px;
    margin-top: $gutter-big;
    margin-bottom: $gutter-big;

    & li {
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        align-items: center;
        padding: 0.5rem;
        gap: 10px;
    }
}

.item {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 10px;
    justify-content: flex-end;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    padding: $gutter-small;
    border: none;
    background-color: transparent;
    color: $lightWhite;
    font-size: 1rem;
}

.title {
    font-size: 1.3rem;
    color: $lightWhite;
    margin-top: $gutter-big;
}

.register {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: $gutter-big 0;
    background-color: $mediumBlue;
}

.registerForm {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: $gutter-big;
    margin: $gutter-big 0;
    gap: $gutter-small;
    width: 100%;
}

input {
    width: 100%;
    height: 50px;
    padding: 0 $gutter-small;
    margin-bottom: $gutter-big;
    border: none;
    border-radius: 5px;
}

label {
    font-size: 14px;
    margin-bottom: $gutter-small;
    font-weight: 200;
    color: $lightWhite;
}

.lastUser {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: $gutter-big;
    margin: 0 0 $gutter-big 0;
    background-color: $green;

    & span {
        color: $lightWhite;
        width: 80%;
    }
}

.results {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1.5rem;
    margin: 0 0 $gutter-big 0;
    background-color: $green;
    flex-direction: column;
    gap: 10px;

    & span {
        color: $lightWhite;
        width: 80%;
    }
}

.deleteMessage {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: $gutter-big;
    margin: 0 0 $gutter-big 0;
    background-color: $green;
    position: relative;

    & span {
        color: $lightWhite;
        width: 80%;
    }
}


// transition par defaut fade in/out
.v-enter-active,
.v-leave-active {
  transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
  opacity: 0;
}

// transition nested elements
.nested-enter-active, .nested-leave-active {
	transition: all 0.3s ease-in-out;
}
/* delay leave of parent element */
.nested-leave-active {
  transition-delay: 0.25s;
}

.nested-enter-from {
  transform: translateY(30px);
  opacity: 0;
}

.nested-leave-to {
  transform: translateY(-30px);
  opacity: 0;
}

/* we can also transition nested elements using nested selectors */
.nested-enter-active .inner,
.nested-leave-active .inner { 
  transition: all 0.3s ease-in-out;
}
/* delay enter of nested element */
.nested-enter-active .inner {
	transition-delay: 0.25s;
}

.nested-enter-from .inner,
.nested-leave-to .inner {
  transform: translateX(30px);
  opacity: 0.001;
}

// list transition

.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}

</style>