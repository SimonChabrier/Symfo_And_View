<template>
  <h1>{{ message }}</h1>
</template>

<script>

/////////////////// import des composants ///////////////////

// import NavBarComponant from '@comp/NavBarComponent.vue'
// import ... from '@comp/...'

/////////////////// export du composant ///////////////////

export default {

name: 'View',

components: {
    //  NavBarComponant,
    //  ...
},

/////////////////// state local ///////////////////

data () {
    return {
        message: '',
    }
},

/////////////////// méthodes ///////////////////

methods : {
    // définir les méthodes si besoin
    check() { 

        if (this.message.length > 0 ) {
            return true
        }
        return false
    },
},

/////////////////// computed ///////////////////

computed: {

    get() { 
        return this.message 
    },

    set() { 
        this.message = 'Hello World' 
    },
},

/////////////////// lifecycle hooks dans l'ordre d'exécution  ///////////////////

beforeCreate () {
   // Called immediately when the instance is initialized, after props resolution, before processing other options such as data() or computed.
   // console.log('beforeCreate')
},
created () {
    // Called after the instance has finished processing all state-related options
    // console.log('created')
},
beforeMount () {
    // When this hook is called, the component has finished setting up its reactive state, but no DOM nodes have been created yet. 
    // It is about to execute its DOM render effect for the first time.
    // console.log('beforeMount')   
},
mounted () {
    // Called after the component has been mounted to the DOM.
    // console.log('mounted')
    document.title = "Register";
},
beforeUpdate () {
    // Called after the component has updated its DOM tree due to a reactive state change.
    // console.log('beforeUpdate')
},
updated () {
    // Called after the component has updated its DOM tree due to a reactive state change.
    // console.log('updated') 
},
beforeDestroy () {
    // Called before the component is destroyed.
    // console.log('beforeDestroy')
},
destroyed () {
    // Called after the component has been destroyed.
    // console.log('destroyed') 
},
}

</script>

<style lang="scss" scoped>
// selecteurs et propriétés css
</style>