<template>

    <div class="button">
        <button @click="onClick">
        {{ text }}
        </button>
    </div>

</template>

<script>

/////////////////// export du composant ///////////////////

export default {

    name: 'ButtonComponent',
    
    props: {
        text: {
            type: String,
            required: true
        }
    },
    
    methods: {
        onClick() {
            this.$emit('click')
        }
    }
}
</script>

<style lang="scss" scoped>

.button {
    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
}

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

    &:hover {
        background-color: $orange;
    }
}


</style>