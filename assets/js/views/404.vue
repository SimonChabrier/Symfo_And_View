<template>
    <div class="notfound">
        <span>{{ message }}</span>
    </div>
</template>

<script>

export default {

    name: 'error404',

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
        padding: 1rem;
        text-align: center;
        padding: 0;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }

    span {
        font-size: 4rem;
        color: $lightWhite;
    }
</style>