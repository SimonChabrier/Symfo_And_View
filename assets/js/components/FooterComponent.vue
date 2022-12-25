<template>

    <div class="footer">
        <NavBarComponant />
    </div>

</template>

<script>

import NavBarComponant from '@comp/NavBarComponent.vue'

export default {

    name: 'FooterComponent',

    components: {
        NavBarComponant
    },

}
</script>

<style lang="scss" scoped>
.footer {
    background-color: $mediumBlue;
    padding: 1rem;
    text-align: center;
    padding: 0;
}

</style>