<template>
    <div class="nav-item" :class="{activity:active}" @click="onSelect">
        <Icon :type="icon" size="20"></Icon> <slot></slot>
    </div>
</template>

<script>
    export default {
        computed: {
            active() {
                let currNav = this.$store.state.home.currNav;
                if(currNav == this.index) {
                    return true;
                } else {
                    return false;
                }
            }
        },
        props:['icon','index'],
        methods: {
            onSelect() {
                this.$store.commit('setLeftMenu',this.index);
                let page = this.$store.state.home.menu[this.index].sub[0].sub[0];
                this.$store.commit('openPage',page);
            }
        }
    }
</script>