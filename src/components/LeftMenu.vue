<template>
    <div class="left-menu">
        <Menu theme="dark" active-name="0-0" :open-names="[0]" @on-select="openPage" :style="{ height: height + 'px' }" ref="menu">

            <Submenu :name="i" v-for="(group,i) in leftMenu" :key="i">
                <template slot="title">
                    <Icon type="stats-bars"></Icon>
                    {{group.name}}
                </template>
                <Menu-item :name="i+'-'+j" v-for="(item,j) in group.sub" :key="j">{{item.name}}</Menu-item>
            </Submenu>


        </Menu>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                height:0,
            }
        },
        computed: {
            leftMenu() {
                return this.$store.state.home.leftMenu
            }
        },
        mounted() {
            this.height = window.innerHeight - 50;
        },
        methods: {
            openPage(name) {
                let keys = name.split('-');
                let page = this.leftMenu[keys[0]].sub[keys[1]];
                this.$store.commit('openPage',page);
            }
        },
        updated () {
            this.$nextTick(() => {
                this.$refs.menu.updateOpened();
                this.$refs.menu.updateActiveName();
            });
        },
    }
</script>

<style>
    .left-menu {
        float: left;
    }
</style>