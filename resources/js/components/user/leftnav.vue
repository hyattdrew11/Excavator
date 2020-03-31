<template>
    <div id="left-nav" class="">
        <ul>
            <li  v-for="(x, index) in items">
                <i :class="'fa fa-'+x.icon" class="mr-1"></i> {{ x.name }}
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "efrom",
        props: [],
        data() {
            return { 
                items : [
                    {
                        name: "Home",
                        icon: 'home'

                    },
                     {
                        name: "Districts",
                        icon: 'circle'

                    },
                     {
                        name: "Private Studio",
                        icon: 'lock'

                    },
                     {
                        name: "Insights",
                        icon: 'eye'

                    },
                     {
                        name: "Collections",
                        icon: 'circle'

                    },
                    {
                        name: "Workflow Results",
                        icon: 'circle'

                    }
                ]
            }
        }
    }
</script>
<style lang="scss">
    #navbarDropdown {
        // border-left: 3px solid #EEE;
    }
    #left-nav {
        float: left;
        height: 100vh;
        width: 15%;
        display: inline-block;
        background-color: #032f42;
        padding: 15px 2px 15px 30px;
    }
    #left-nav ul {
        padding-inline-start: 0px;
        list-style: none;
        color: #FFF;
        font-size: 14px;
        font-weight: 500;
        color: #FFF;
    }
    #left-nav li {
        margin: 15px 0px 15px 0px;
    }
</style>