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
      // définir les données ici si nécessaire
    }
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
};

</style>