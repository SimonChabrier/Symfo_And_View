<template>
    <div class="register">

        <div class="info">
            <h1 v-if="successMessage">{{ successMessage }}</h1>
            <h1 v-if="errorMessage">{{ errorMessage }}</h1>
            <p></p>
        </div>

        <form class= "registerForm" action="">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" placeholder="Username" v-model="username">
            
            <label for="email">Email</label>
            <input type="text" placeholder="Email" v-model="email">
            
            <label for="password">Mot de passe</label>
            <input type="text" placeholder="Password" v-model="password">
            
            <label for="confirmPassword">Confirmer le mot de passe</label>
            <input type="text" placeholder="Confirm Password" v-model="confirmPassword">
            
            <input type="submit" value="S'inscrire" @click="submitForm">
            
        </form>

    </div>
</template>

<script>
import axios from 'axios';
export default {

    name: 'RegisterView',

    // state
    data () {
        return {
            username: '',
            email: '',
            password: '',
            confirmPassword: '',
            successMessage: '',
            errorMessage: ''
        }
    },
    methods : {
        submitForm () {
            // get data from form
            let datas = {
                username: this.username,
                email: this.email,
                password: this.password,
                confirmPassword: this.confirmPassword
            }
            this.postData(datas);
        },

        async postData (datas) {

            // always start with empty messages
            this.successMessage = '';
            this.errorMessage = '';

            try {
                await axios.post('https://127.0.0.1:8000/api/register', datas)
                this.successMessage = 'Votre compte a bien été créé';
                this.redirect();
            } catch (error) {
                this.errorMessage = `${error.message}`;
            } 
        },
        redirect () {
            setTimeout(() => {
                this.$router.push({ name: 'home' })
            }, 2000);
        }
    },
}
</script>

<style lang="scss" scoped>


.register {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    margin: 20px 0;
}

.registerForm {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding: 20px;
    margin: 20px 0;
    gap: 10px;
}

input {
    width: 600px;
    height: 50px;
    padding: 0 10px;
    margin-bottom: 20px;
    border: none;
    border-radius: 5px;
}

label {
    font-size: 14px;
    font-weight: 200;
    color: #333;
}

input[type="submit"] {
    width: 100px;
    height: 40px;
    background-color: rgb(182, 48, 48);
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}


</style>