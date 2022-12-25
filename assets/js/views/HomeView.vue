<template>
    <div class="home">
        <h1 class="title">{{ title }}</h1>
        <!-- liste des users -->
        <ul>
            <li v-for="user in users" :key="user.id">
               <!-- router view pour lier chaque user à son profil -->
                <router-link :to="{ name: 'user', params: { id: user.id }}">
                    {{ user.username }}
                </router-link>
            </li>
        </ul>
    </div>
</template>

<script>
export default {

    name: 'HomeView',

    // state
    data () {
        return {
            title : "",
            users: []
        }
    },
    // imort des users depuis le store
    mounted () {
        this.$store.dispatch('fetchUsers')
        .then(() => {
            this.users = this.$store.state.users
            this.users.length === 0 ? this.title = "Aucun utilisateur en BDD !" : this.title = "Liste des utilisateurs"
            console.log(this.users.length)
        })
    }

}

</script>

<style lang="scss" scoped>

.home {
    display: flex;
    background-color: $mediumBlue;
    justify-content: center;
    align-items: center;
    height: 400px;
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

</style>