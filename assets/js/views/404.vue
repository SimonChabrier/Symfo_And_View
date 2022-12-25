<template>
    <div class="notfound">
        <!-- <span>{{ message }}</span> -->
        <button @click="count++">
            You clicked me {{ count }} times.
    </button>
    </div>
</template>

<script>

export default {

    name: 'error404',
    message: '404 Not Found',

    data() {
        return {
            count: 0
        }
    },
    methods: {
        increment() {
            console.log('increment')
            this.count++
        }
  },
  computed: {
    message() {
      return `You clicked me ${this.count} times.`
    }
  }
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
    }

    span {
        font-size: 8rem;
        color: $lightWhite;
    }
</style>