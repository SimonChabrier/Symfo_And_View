<template>
  <div>
      <!-- insérer le composant header ici -->
      <HeaderComponent
      :title="headerTitle"
      :subtitle="headerSubtitle"
      />

      <!-- insérer le composant navbar ici -->
      <NavBarComponant />

      <!-- <router-view/> insère la view demandé sur la route ici -->
      <router-view/>

      <!-- insérer le composant footer ici -->
        <FooterComponent />
    </div>
  </template>
  
  <script>

  import HeaderComponent from './js/components/HeaderComponent.vue'
  import NavBarComponant from './js/components/NavBarComponent.vue'
  import FooterComponent from './js/components/FooterComponent.vue'

  export default {
  
    name: 'App',
  
    components: {
      HeaderComponent,
      NavBarComponant,
      FooterComponent
    },
  
    data() {
      return {
        headerTitle: '10 minutes',
        headerSubtitle: 'O\'Four',
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
    background-color: #f5f5f5;
    
  }
    
</style>