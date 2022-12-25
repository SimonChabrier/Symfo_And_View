<template>
  <div>
      <!-- insérer le composant navbar ici -->
      <NavBarComponant />

      <!-- <router-view/> insère la view demandé sur la route ici -->
      <router-view/>

      <!-- insérer le composant footer ici -->
        <FooterComponent />
    </div>
  </template>
  
  <script>

  import NavBarComponant from '@app/components/NavBarComponent.vue'
  import FooterComponent from '@app/components/FooterComponent.vue'
  // import des variables de style
  // import './styles/_vars.scss';

  export default {
  
    name: 'App',
  
    components: {
      NavBarComponant,
      FooterComponent
    },
  
    data() {
      return {
        headerTitle: 'Header Title',
        headerSubtitle: 'Header Subtitle',
      }
    }
  }
  </script>
  
  <style lang="scss">
  
  * {
    box-sizing: border-box;
  }
  
  body {
    font-family: 'Open Sans', sans-serif;
    color: #333;
    font-size: 16px;
    background-color: $lightblue;
    
  }
    
</style>