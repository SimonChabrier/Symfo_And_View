<template>

    <div class="last" v-if="lastUser.username">
        <span>
            Dernier utilisateur inscrit : {{ lastUser.username }}
        </span>
    </div>

    <div class="home">
        <h1 class="title">{{ info }} </h1>
        
        <!-- liste des users -->
        <ul>
            <li v-for="user in $store.state.users" :key="user.id"><!-- boucle directement sur le store -->
                <router-link :to="{ name: 'user', params: { id: user.id }}"><!-- router link pour lier chaque user à son profil -->
                    {{ user.username }} 
                </router-link>
                <!-- delete button -->
            </li>
        </ul>

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

/////////////////// export du composant ///////////////////

export default {

    name: 'HomeView',

    components: {
        ButtonComponent
    },

 /////////////////// state local ///////////////////

    data () {
        return {
            info : "",
            "count": '',
            users: [],
            lastUser: {}, 
            username: '',
            email: '',
            password: '',
        }
    },
    /////////////////// méthodes ///////////////////

    methods : {
        register () { 
            this.$store.dispatch('registerUser', this.getFormDatas) 
        },
    },
   
    /////////////////// computed ///////////////////

    computed : {
        getFormDatas () { 
            return { username: this.username, email: this.email, password: this.password } 
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
        this.users = this.$store.dispatch('fetchUsers');
    },
    beforeUpdate () {
        // console.log('beforeUpdate')
        this.info = this.$store.state.users.length + " utilisateurs inscrits";
    },
    // appelé à chaque action sur le composant
    updated () {
        // console.log('updated') 
        this.lastUser = this.$store.state.user;
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
        margin-bottom: $gutter-small;
    }

    & ul, li {
        list-style: none;
        color: $lightWhite;
        line-height: $gutter-big;
    }
}

.register {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: $gutter-big;
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
    width: 80%;
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

</style>