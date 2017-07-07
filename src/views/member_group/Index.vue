<template>
    <span>
        <div class="list-operate">
            <Button type="primary" icon="ios-plus-outline" size="large" @click="edit">添加</Button>
        </div>
        <Table :columns="columns.concat(operate)" :data="list"></Table>

        <MyPage :total="total" @on-change="page"></MyPage>
    </span>
</template>
<script>
    import indexMixin from '../../mixins/indexMixin';
    import Privilege from './Privilege.vue'
    export default {
        mixins: [indexMixin],
        data () {
            return {
                current_module:'member_group',
                columns: [
                    {
                        title: 'ID',
                        key: 'id',
                        width: 60
                    },{
                        title: '权限组名称',
                        key: 'name',
                    }
                ]
            }
        },
        methods: {
            operateAdd(h, params) {
                return [
                    h('Button', {
                        props: {
                            type: 'primary',
                            size: 'small'
                        },
                        style: {
                            marginLeft: '5px'
                        },
                        on: {
                            click: () => {
                                this.privilege(params)
                            }
                        }
                    }, '配置权限'),
                ];
            },
            privilege(params) {
                this.$store.dispatch('getPrivilege',params.row.id);
                this.$store.commit('modalShow',true);
                this.$store.commit('modalComponent',Privilege);
            },
        }

    }
</script>
