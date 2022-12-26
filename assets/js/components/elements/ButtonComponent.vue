<template>

    <button :class="color" @click="onClick">
        {{ text }}
    </button>

</template>

<script>

/////////////////// export du composant ///////////////////

export default {

    name: 'ButtonComponent',
    
    props: {
        text: {
            type: String,
            required: true
        },
        color : {
            type: String,
            required: false,
            default: 'green'
        }
    },
    
    methods: {
        onClick() {
            this.$emit('click')
            console.log('click')
        }
    },
}
</script>

<style lang="scss" scoped>

button {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    background-color: $green;
    color: $lightWhite;
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all .3s ease-in-out;
}

.green {
    background-color: $green;
}

.orange {
    background-color: $orange;
}

.red {
    background-color: $red;
}





</style>