<template>
    <NavBarComponant />
      <router-view />
    <FooterComponent />
</template>
  
<script>

import NavBarComponant from '@comp/NavBarComponent.vue'
import FooterComponent from '@comp/FooterComponent.vue'

export default {

  name: 'App',

  components: {
    NavBarComponant,
    FooterComponent
  },

  data() {
    return {
      // définir le state initial si besoin
      // message : "Hello World"
    }
  },

  mounted () {
    // import des users dans le store 
    // pour pouvoir boucler dessus dans les templates
    
  }
}


</script>
  
<style lang="scss">

* {
box-sizing: border-box;
};
  
body {
  font-family: 'Open Sans', sans-serif;
  font-size: 16px;
  width: 80%;
  margin: 0 auto;
};

</style>