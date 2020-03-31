<template>
    <div id="notifications" class="">
         <i class="fa fa-bell"></i>
    </div>
</template>

<script>
    export default {
        name: "notifications",
        props: [],
        data() {
            return {}
        }
    }
</script>
<style lang="scss">
    #notifications {
        position: fixed;
        top: 17px;
        right: 215px;
        font-size: 16px;
    }
</style>