<template>
    <div id="app">
        <Home v-if="loginStatus"></Home>
        <Login v-if="!loginStatus"></Login>
    </div>
</template>

<script>
    import Cookie from './utils/Cookie'
    import Login from './views/Login.vue'
    import Home from './views/Home.vue'


    export default {
        computed: {
            loginStatus () {
                return this.$store.state.login.status
            }
        },
        beforeCreate() {
            //判断登陆
            let login_id = Cookie.get("login_id");
            if(login_id) {
                this.$store.commit('loginStatus',true);
            }
        },
        components: {
            Login,
            Home
        }
    }
</script>