<template>
    <div class="page-tab">
    <Tabs type="card" closable @on-tab-remove="handleTabRemove" :value="currTab" :animated="false" ref="tabs">
        <Tab-pane v-for="(item,index) in pageTab" :key="index" :label="item.name"><component :is="item.component"></component></Tab-pane>
    </Tabs>
    </div>
</template>
<script>
    export default {
        computed: {
            pageTab () {
                return this.$store.state.home.pageTab
            },
            currTab() {
                return this.$store.state.home.currTab
            }
        },
        methods: {
            handleTabRemove (name) {
                this.$store.commit('closePage',name);
            }
        },
        updated () {
            this.$nextTick(() => {
                this.$refs.tabs.updateNav();
            });
        },
    }
</script>
<style>
    .page-tab {
        margin-top: 10px;
    }
    .ivu-tabs-nav {
        padding-left: 15px;
    }
</style>