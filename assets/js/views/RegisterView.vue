<template>
    <div class="register">
        <form class= "registerForm" action="">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" placeholder="Username" v-model="username">
            
            <label for="email">Email</label>
            <input type="email" placeholder="Email" v-model="email">
            
            <label for="password">Mot de passe</label>
            <input type="password" placeholder="Password" v-model="password">
            
            <label for="confirmPassword">Confirmer le mot de passe</label>
            <input type="password" placeholder="Confirm Password" v-model="confirmPassword">
            
            <input type="submit" value="S'inscrire" @click="register">
            
        </form>

    </div>
</template>

<script>

/////////////////// import des composants ///////////////////

// import axios from 'axios';

/////////////////// export du composant ///////////////////

export default {

    name: 'RegisterView',

    components: {
        // définir les composants utilisés dans le template
    },

    /////////////////// state local ///////////////////

    data () {
        return {
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
        }
    },

    /////////////////// méthodes ///////////////////

    methods : {
        register () { 
            this.$store.dispatch('registerUser', this.getFormDatas)
            this.$router.push({ name: 'home' }) 
            },
    },

    /////////////////// computed ///////////////////

    computed: {
        getFormDatas () {
            return {
                username: this.username,
                email: this.email,
                password: this.password,
                confirmPassword: this.confirmPassword
            }
        }
    },

    /////////////////// lifecycle hooks dans l'ordre d'exécution  ///////////////////

    beforeCreate () {
        // ici je n'ai pas encore accès au store
    },
    created () {
        // console.log('created')
    },
    beforeMount () {
        // console.log('beforeMount')   
    },
    mounted () {
        // console.log('mounted')
        document.title = "Register";
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

h1 {
    font-size: 24px;
    font-weight: 200;
    color: $green;
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

input[type="submit"] {
    width: 100px;
    height: 40px;
    background-color: $red;
    margin : $gutter-medium 0 0 0;
    color: $lightWhite;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


</style>