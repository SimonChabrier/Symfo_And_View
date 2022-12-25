<template>
    <div class="user">
        <ol>
            <li>
                Profil de : {{ user.username }}
            </li>
            <li>
                Email : {{ user.email }}
            </li>
            <li>
                Id: {{ user.id }}
            </li>
            <li v-for="role in user.roles" :key="role">
                Roles: {{ role }}
            </li>
            <li>
                Utilisateur vérifié : {{ user.isVerified === true ? 'oui' : 'non' }}
            </li>
            <li>
                Utilisateur actif : {{ user.status === true ? 'oui' : 'non' }}
            </li>
            <li>
                Crée le : {{ date(user.createdAt) }}
            </li>
            <li>
                A : {{ time(user.createdAt) }}
            </li>
            <li>
                Modifié le : {{ date(user.updateAt) }}
            </li>
            <li>
                A : {{ time(user.updateAt) }}
            </li>
            <!-- delete user button -->
            <li>
                <input type="submit" value="Supprimer" @click="deleteUser(user.id)">
            </li>
        </ol>
    </div>
</template>

<script>

import utils from '@utils/utils.js';

export default {

    name: 'UserView',

    // state
    data () {
        return {
            user: {}
        }
    },
    methods: {
        deleteUser (id) {
            this.$store.dispatch('deleteUser', id)
            .then(() => {
                this.$router.push({ name: 'home' })
            })
        },
        // formatDate accèssible depuis l'import d'utils.js
        // la clé 'date' est utilisée dans le template
        // elle contient maintenant la fonction formatDate de l'ojet utils
        date: utils.formatFrenchDate,
        time: utils.formatTime
    },
    // import du user depuis store par son id
    mounted () {
        this.$store.dispatch('fetchUser', this.$route.params.id)
        .then(() => { this.user = this.$store.state.user, console.log(this.user)})
    }
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