<template>
    <div class="nav-bar">
            <router-link to="/">Home</router-link> |
            <router-link to="/register">Register</router-link>
    </div>
</template>

<script>
export default {
    name: 'NavBarComponent',
    //message: 'Hello World, I am a NavBarComponent',
}
</script>

<style lang="scss" scoped>
.nav-bar {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px 0;
  margin: 20px 0;
}

.nav-bar a {
  font-weight: bold;
  color: #333;
  text-decoration: none;
  font-size: 1.2rem;
  padding: 0 1rem;
}
.nav-bar a.router-link-exact-active {
  color:rgb(182, 48, 48);
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