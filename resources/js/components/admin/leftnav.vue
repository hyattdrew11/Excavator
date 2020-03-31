<template>
    <div id="left-nav" class="">
        <ul>
            <li  v-for="(x, index) in items">
                <a :href="x.href" class="white">
                    <i :class="'fa fa-'+x.icon" class="mr-1"></i> {{ x.name }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "efrom",
        props: ['connections'],
        watch: { 
            connections: function(newVal, oldVal) { 
                if(newVal) {
                    this.connections = newVal
                }
            }
        },
        data() {
            return { 
                items : [
                    {
                        name: "Home",
                        icon: 'home',
                        href:'/home'

                    },
                     {
                        name: "Users",
                        icon: 'user',
                        href:'/users'

                    },
                     {
                        name: "SMTP",
                        icon: 'plug',
                        href:'/smtp'

                    },
                    {
                        name: "Jobs",
                        icon: 'paper-plane',
                        href:'/jobs'

                    }
                ]
            }
        },
        mounted() {
            setTimeout(() => { this.checkSMTP() }, 500)
            // this.checkSMTP()
        },
        methods: {
            checkSMTP() {
                if(this.connections == null || this.connections.length == 0) {
                    // alert('You do not have an SMTP connection setup.')
                }
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