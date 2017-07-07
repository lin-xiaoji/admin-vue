<template>
    <div class="nav-container">
        <div class="nav-logo">
            <img src="images/logo.png" />
        </div>
        <Nav>
            <NavItem v-for="(item,i) in menu" :key="i" :icon="item.icon" :index="i">{{item.name}}</NavItem>
        </Nav>
        <div class="nav-link">
                欢迎您，{{username}} <span @click="logout">退出</span>
        </div>
    </div>
</template>

<script>
    import Cookie from '../utils/Cookie'
    import NavItem from './NavItem.vue'
    import Nav from './Nav.vue'
    export default {
        data () {
            return {
                username:Cookie.get("username")
            }
        },
        computed: {
            menu() {
                return this.$store.state.home.menu
            }
        },
        methods: {
            logout() {
                Cookie.delete('login_id');
                Cookie.delete('username');
                Cookie.delete('token');
                this.$store.commit('loginStatus',false);
            }
        },
        components: {
            NavItem
        }
    }
</script>
<style>
    .nav-container {
        background-color: #2a94de;
        height: 50px;
        color: #fff;
        font-weight: bold;
        line-height: 50px;
    }
    .nav-container div {
        float: left;
    }



    .nav-container .nav-logo {
        background-color: #096db8;
        height: 50px;
        padding-top: 8px;
        padding-left: 15px;
        width: 240px;
    }


    .nav-container .nav-item {
        width: 150px;
        font-size: 16px;
        text-align: center;
        font-family:黑体;
        cursor: pointer;
    }

    .nav-container .activity {
        background: #1484d0;
    }

    .nav-container .nav-link {
        float: right;
        font-weight: normal;
        padding-right: 20px;
        font-size: 14px;
    }
    .nav-container .nav-link span{
        cursor: pointer;
    }


</style>
