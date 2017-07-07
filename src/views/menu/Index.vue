<template>
    <span>
        <div class="list-operate">
            <Button type="primary" icon="ios-plus-outline" size="large" @click="edit">添加</Button>
        </div>
        <Table :columns="columns.concat(operate)" :data="list"></Table>
    </span>
</template>
<script>
    import indexMixin from '../../mixins/indexMixin';
    export default {
        mixins: [indexMixin],
        data () {
            return {
                current_module:'menu',
                columns: [
                    {
                        title: 'ID',
                        key: 'id',
                        width: 60
                    },{
                        title: '排序',
                        key: 'sort',
                        width: 100
                    },{
                        title: '栏目名称',
                        key: 'name',
                        render(h, params) {
                            var tabs = '';
                            if(params.row.level == 2) {
                                tabs = tabs + '　　　　'
                            }
                            if(params.row.level == 3) {
                                tabs = tabs + '　　　　　　　　'
                            }
                            return h('div',tabs+params.row.name);
                        }
                    },
                    {
                        title: '目录',
                        key: 'module'
                    },
                    {
                        title: '控制器',
                        key: 'controller'
                    },
                    {
                        title: '方法',
                        key: 'method'
                    },
                    {
                        title: 'view',
                        key: 'view'
                    },
                    {
                        title: 'icon',
                        key: 'icon'
                    },

                ],
                modal:false
            }
        },

    }
</script>
