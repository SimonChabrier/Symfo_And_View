<template>

<div class="search">
    <input type="text" placeholder="Rechercher un utilisateur" v-model="search" @input="getSearchDatas">
</div>

<div class="results" v-if="$store.state.searchUsers.length">
    <div class="item" v-for="user in $store.state.searchUsers" :key="user.id">
        <!-- router link pour lier chaque user à son profil -->
        <router-link :to="{ name: 'user', params: { id: user.id }}">
            {{ user.username }}
        </router-link>
            
        <button aria-label='delete item' v-if="user" 
            @click = "deleteUser(user.id)" 
            type='button'> X
        </button>
    </div>
</div>

<div class="deleteMessage" v-if="$store.state.deleteMessage">
    <button class="close" aria-label='close message'
        @click = "closeDeleteMessage()" 
        type='button'> X
    </button>
    <span>
        {{ $store.state.deleteMessage }}
    </span>
</div>

<div class="last" v-if="lastUser.username">
    <button class="close" aria-label='close message'
        @click = "closeNewUserCreatedMessage()" 
        type='button'> X
    </button>
    <span>
        Dernier utilisateur inscrit : {{ lastUser.username }}
    </span>
</div>

<div class="home">
    <h1 class="title">{{ $store.state.count > 1 ? `${$store.state.count} utilisateurs enregistrés` : `${$store.state.count} utilisateur enregistré` }} </h1>
    
    <!-- liste des users -->
    <div class="users">
        <div class="item" v-for="user in $store.state.allUsers" :key="user.id">
            <!-- router link pour lier chaque user à son profil -->
            <router-link :to="{ name: 'user', params: { id: user.id }}">
                <span v-if="!user.message">
                    {{ user.username }} 
                </span>
            </router-link>
                
            <button aria-label='delete item' v-if="!user.message" 
                @click = " deleteUser(user.id) " 
                type='button'> X
            </button>
        </div>
    </div>
</div>

<div class="register" @submit.prevent="register">
    <form class= "registerForm">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" placeholder="Username" v-model="username">
        
        <label for="email">Email</label>
        <input type="email" placeholder="Email" v-model="email">
        
        <label for="password">Mot de passe</label>
        <input type="password" placeholder="Password" v-model="password">
        
        <button-component 
            @click="''" 
            :text="'inscription'" 
            :color="'red'">
        </button-component>
    </form>
</div>  

</template>

<script>

/////////////////// import des composants ///////////////////

// import axios from 'axios';
import ButtonComponent from '@comp/elements/ButtonComponent.vue'
import utils from '../utils/utils'

/////////////////// export du composant ///////////////////

export default {

    name: 'HomeView',

    components: {
        ButtonComponent
    },

 /////////////////// state local ///////////////////

    data () {
        return {
            lastUser: {}, 
            username: '',
            email: '',
            password: '',
            search: '',
        }
    },
    /////////////////// méthodes ///////////////////

    methods : {
        register () { 
            this.$store.dispatch('registerUser', this.getFormDatas) 
            this.resetForm()
            this.lastUser = this.$store.state.allUsers[this.$store.state.allUsers.length - 1];
        },
        deleteUser (id) { 
            this.$store.dispatch('deleteUser', id)
            this.$store.dispatch('removeDeletedUserFromUsers', id)   
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
            this.lastUser = {}
        },
    },
   
    /////////////////// computed ///////////////////

    computed : {
        getFormDatas () { 
            return { username: this.username, email: this.email, password: this.password } 
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
        // console.log(this.$store.state.searchUsers)
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

.home {
    display: flex;
    background-color: $mediumBlue;
    justify-content: center;
    align-items: center;
    min-height: 400px;
    padding: $gutter-big 0;
    margin: 0 auto;
    flex-direction: column;

    & .title {
        font-size: large;
        font-size: 1.5rem;
        color: $lightWhite;
        margin-bottom: $gutter-medium;
    }

    & ul, li {
        list-style: none;
        color: $lightWhite;
        line-height: $gutter-big;
    }
}

.users {
    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    gap: 10px;
}

.item {
    display: flex;
    align-items: center;
    width: 100%;
    gap: 10px;
    justify-content: flex-end;
}

.deleteMessage {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: $gutter-big;
    margin: $gutter-big 0;
    background-color: $green;
    position: relative;

    & span {
        color: $lightWhite;
    }
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

.last {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: $gutter-big;
    margin: $gutter-big 0;
    background-color: $green;

    & span {
        color: $lightWhite;
    }
}

.results {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 1.5rem;
    margin: 1.5rem 0;
    background-color: $green;
    flex-direction: column;
    gap: 10px;

    & span {
        color: $lightWhite;
    }
}

</style>