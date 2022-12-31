<template>
    <div class="nav-bar">
            <router-link @click="resetUser" to="/">Home</router-link> |
            <router-link to="/register">Register</router-link>
    </div>
</template>

<script>
export default {
    name: 'NavBarComponent',
    
    data() {
        return {
            message: 'Hello from NavBarComponent'
        }
    },

    methods: {
        resetUser() {
          this.$store.dispatch('resetUser', {});
          console.log('resetUser');
        }
      
    }
}
</script>

<style lang="scss" scoped>
.nav-bar {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px 0;
  margin-bottom: $gutter-big;
  margin-top: $gutter-small;
  color: $lightWhite;
  background-color: $mediumBlue;
}

.nav-bar a {
  font-weight: bold;
  text-decoration: none;
  font-size: 1.2rem;
  padding: 0 $gutter-medium;
}
.nav-bar a.router-link-exact-active {
  color: $orange
}


@media only screen and (min-width: 1200px) {
  .nav-bar {
  padding: 30px 0;
}
  
.nav-bar a {
  font-size: 1.4rem;
  padding: 1rem;
}
    
}
</style>