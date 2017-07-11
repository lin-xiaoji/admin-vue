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
    export default {
        mixins: [indexMixin],
        data () {
            return {
                currentModule:'article',
                columns: [
                    {
                        title: 'ID',
                        key: 'id',
                        width: 60
                    },{
                        title: '文章标题',
                        key: 'title',
                    }
                ]
            }
        }

    }
</script>
