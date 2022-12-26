<template>
    <NavBarComponant />
      <router-view />
    <FooterComponent />
</template>
  
<script>

/////////////////// import des composants ///////////////////

import NavBarComponant from '@comp/NavBarComponent.vue'
import FooterComponent from '@comp/FooterComponent.vue'

/////////////////// export du composant ///////////////////

export default {

  name: 'App',

  components: {
    NavBarComponant,
    FooterComponent
  },

  /////////////////// state local ///////////////////

  data() {
    return {
      // définir le state initial si besoin
      // message : "Hello World"
    }
  },

  /////////////////// méthodes ///////////////////
  
  methods: {
    // définir les méthodes si besoin
  },

  /////////////////// computed ///////////////////

  computed: {
    // Accèder données calculées dans le state local si besoin
    // sans les recalculer à chaque fois contrairement à une méthode
    // qui sera recalculée à chaque appel

    // eg : getMessage() { return this.message }
  },

  /////////////////// lifecycle hooks dans l'ordre d'exécution  ///////////////////

  beforeCreate() {
    // console.log('beforeCreate')
  },
  created() {
    // console.log('created')
  },
  beforeMount() {
    // console.log('beforeMount')
  },
  // appelé à l'initialisation du composant
  mounted() {
    // console.log('mounted')
  },
  beforeUpdate() {
    // console.log('beforeUpdate')
  },
  // appelé à chaque action sur le composant
  updated() {
    // console.log('updated')
  },
  beforeDestroy() {
    // console.log('beforeDestroy')
  },
  destroyed() {
    // console.log('destroyed')
  },

}

</script>
  
<style lang="scss">

* {
box-sizing: border-box;
};
  
body {
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  width: 90%;
  margin: 0 auto;
  background-color: $mediumGray;
};

a {
  text-decoration: none;
  color: $lightWhite;
  transition: all 0.2s ease-in-out;

  &:hover {
    color: $orange;
  }
  &:active {
    color: $orange;
  }
};

// media queries

@media screen and (min-width: 768px) {
  body {
    width: 400px;
  }
};

</style>