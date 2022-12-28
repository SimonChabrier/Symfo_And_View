<template>
  <!-- login form -->

    <div class="login">

        <div class="title">
            <h1>Connexion</h1>
        </div>

        <form class="loginform">
            <div v-if="$store.state.loggedIn === false">
            
            <label for="usernme">Nom d'utilisateur</label>
            <input
            type="text"
            class="form-control"
            id="username"
            placeholder="Nom d'utilisateur"
            v-model="username"
            />

            <label for="password">Password</label>
            <input
            type="password"
            class="form-control"
            id="password"
            placeholder="Password"
            v-model="password"
            />

            <button-component 
                @click="authentication" 
                :text="'connexion'" 
                :color="'orange'">
            </button-component>
            </div>

            <Transition duration="550" name="nested">
                <div v-if="$store.state.loggedIn === true">
                    <button-component 
                        @click="logout()" 
                        :text="'Déconnexion'" 
                        :color="'red'">
                    </button-component>
                </div>
            </Transition>
        </form>
    </div>

</template>

<script>

import ButtonComponent from '@comp/elements/ButtonComponent.vue'
import AuthService from '@sevices/auth.service.js'

export default {

    name: 'LoginFormComponent',

    components: {
        ButtonComponent
    },

    data () {
        return {
            username: '',
            password: '',
        }
    },

    methods: {
        authentication () {
            AuthService.getAuth({ username: this.username, password: this.password })
            this.$store.state.loggedIn = true
        },

        logout () { 
            this.$store.dispatch('logout');
        },
    },
}
</script>

<style lang="scss" scoped>

.title {
    font-size: 1.3rem;
    color: $lightWhite;
    margin-top: $gutter-big;
}

.login {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    margin: 0 0 $gutter-big 0;
    background-color: $mediumBlue;
}

.loginform {
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

// transition nested elements
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
// .nested-leave-active {
//   transition-delay: 0.25s;
// }

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


</style>