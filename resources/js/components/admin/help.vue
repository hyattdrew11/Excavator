<template>
    <div id="help" class="">
         <i class="fa fa-question-circle"></i>
    </div>
</template>

<script>
    export default {
        name: "help",
        props: ['user'],
        data() {
            return {}
        },
        mounted() {}
    }
</script>
<style lang="scss">
    #help {
        position: fixed;
        top: 17px;
        right: 255px;
        font-size: 16px;
    }
</style>