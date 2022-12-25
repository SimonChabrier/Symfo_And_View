<template>
<div class="main">
  <h1>{{ msg }}</h1>
</div>
</template>


<script>
export default {

    name: 'TestView',

    data () {
        return {
            msg: 'test view'
        }
    }

}
</script>

<style lang="scss" scoped>
.main {
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: red;
    height: 400px;
}
</style>