<template>
    <div class="user">
        <ol>
            <li>
                Profil de : {{ $store.state.user.username }}
            </li>
            <li>
                Email : {{ $store.state.user.email }}
            </li>
            <li>
                Id: {{ $store.state.user.id }}
            </li>
            <li v-for="role in $store.state.user.roles" :key="role">
                Roles: {{ role }}
            </li>
            <li>
                Utilisateur vérifié : {{ $store.state.user.isVerified === true ? 'oui' : 'non' }}
            </li>
            <li>
                Utilisateur actif : {{ $store.state.user.status === true ? 'oui' : 'non' }}
            </li>
            <li>
                Crée le : {{ date($store.state.user.createdAt) }}
            </li>
            <li>
                A : {{ time($store.state.user.createdAt) }}
            </li>
            <li>
                Modifié le : {{ date($store.state.user.updateAt) }}
            </li>
            <li>
                A : {{ time($store.state.user.updateAt) }}
            </li>
            <!-- delete user button -->
            <li>
                <div v-if="$store.state.user.username != $store.state.adminName && $store.state.loggedIn === true">
                    <input type="submit" value="Supprimer" @click.prevent="deleteUser">
                </div>
            </li>
        </ol>
    </div>
</template>

<script>

/////////////////// import des composants ///////////////////

import utils from '@utils/utils.js';

/////////////////// export du composant ///////////////////

export default {

    name: 'UserView',

    /////////////////// state local ///////////////////

    data () {
        return {
            //
        }
    },

    /////////////////// méthodes ///////////////////

    methods: {
        // formatDate accèssible depuis l'import d'utils.js
        // la clé 'date' est utilisée dans le template
        // elle contient maintenant la méthode formatDate de l'ojet utils
        date: utils.formatFrenchDate,
        time: utils.formatTime,
        
        async deleteUser () {   
            await this.$store.dispatch('deleteUser', this.$route.params.id)
            this.$router.push({ name: 'home' })
        },
    },



    /////////////////// lifecycle hooks dans l'ordre d'exécution  ///////////////////

    beforeCreate () {
        // console.log('beforeCreate')
        // ici je n'ai pas encore accès au store
    },
    created () {
        // ici je peux accéder au store
        // console.log('created')
    },
    beforeMount () {
        // console.log('beforeMount')
        
    },
    mounted () {
        // console.log('mounted')
        this.$store.dispatch('fetchUser', this.$route.params.id)
        document.title = "User profile"
    },
    beforeUpdate () {
        // console.log('beforeUpdate')
    },
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

.user {
    display: flex;
    flex-direction: column;
    background-color: $mediumBlue;
    justify-content: center;
    align-items: center;
    height: 400px;
    margin: 0 auto;

    & h1, li {
        color: $lightWhite;
        line-height: $gutter-big;
    }
    
}

input[type="submit"] {
    width: 100px;
    height: 40px;
    background-color: $red;
    margin : $gutter-medium 0 $gutter-medium 0;
    color: $lightWhite;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

</style>