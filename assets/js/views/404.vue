<template>
    <div class="notfound">
        <h1>{{ message }}</h1>
         <!-- back to home button on router link -->
        <div class="back-to-home">
            <router-link to="/">
                <button-component 
                        @click="''" 
                        :text="'Retour à l\'accueil'" 
                        :color="'green'">
                    </button-component>
            </router-link>
        </div>
    </div>
</template>

<script>

import ButtonComponent from '@comp/elements/ButtonComponent.vue'

export default {

    name: 'error404',

    components: {
        ButtonComponent
    },

    data() {
        return {
            count: 0,
            message: 'Oupsssss....404 Not Found', 
        }
    },
    methods: {
        increment() {
            console.log('increment')
            this.count++
        }
  },
}
</script>

<style lang="scss" scoped>
    .notfound {
        background-color: $mediumBlue;
        text-align: center;
        width: 100%;
        height: 400px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        align-items: center;
        margin: 0 auto;
    }

    h1 {
        font-size: 2rem;
        color: $lightWhite;
        padding: $gutter-big;
    }
</style>