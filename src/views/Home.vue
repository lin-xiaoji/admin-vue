<template>
    <div id="home">
        <NavBar></NavBar>
        <LeftMenu></LeftMenu>
        <PageTab></PageTab>
        <Modal title="编辑"
               v-model="modalShow"
               :mask-closable="false"
               @on-cancel="closeModal"
               :footer-hide="true">
            <component :is="modalComponent" v-bind="modalParam"></component>
        </Modal>
    </div>
</template>

<script>
    import NavBar from '../components/NavBar.vue'
    import LeftMenu from '../components/LeftMenu.vue'
    import PageTab from '../components/PageTab.vue'

    export default {
        name:'home',
        computed: {
            modalShow() {
                return this.$store.state.modalShow;
            },
            modalParam() {
                return this.$store.state.modalParam;
            },
            modalComponent() {
                return this.$store.state.modalComponent;
            }
        },
        methods: {
            closeModal() {
                this.$store.commit('modalShow',false);
            }
        },
        components: {
            NavBar,
            LeftMenu,
            PageTab,

        },
        mounted() {
            this.$store.dispatch('getMenu');
        }
    }
</script>