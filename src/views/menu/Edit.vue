<template>
    <Form ref="formValidate" :model="formData" :rules="ruleValidate" :label-width="80">
        <Form-item label="所属栏目" prop="city">
            <Select v-model="formData.parent_id">
                <Option v-for="(item,index) in parent" v-if="item.level < 3" :value="item.id" :key="item.id">{{item.level == 2 ? '　　':''}}{{item.name}}</Option>
            </Select>
        </Form-item>

        <Form-item label="栏目名称" prop="name">
            <Input v-model="formData.name" />
        </Form-item>
        <Form-item label="目录" prop="module">
            <Input v-model="formData.module" />
        </Form-item>

        <Form-item label="控制器" prop="controller">
            <Input v-model="formData.controller" />
        </Form-item>

        <Form-item label="方法" prop="method">
            <Input v-model="formData.method" />
        </Form-item>
        <Form-item label="view" prop="view">
            <Input v-model="formData.view" />
        </Form-item>
        <Form-item label="icon" prop="icon">
            <Input v-model="formData.icon" />
        </Form-item>

        <Form-item>
            <Button type="primary" @click="handleSubmit('formValidate')">提交</Button>
        </Form-item>
    </Form>
</template>
<script>
    import editMixin from '../../mixins/editMixin';
    export default {
        mixins: [editMixin],
        data () {
            return {
                currentModule:'menu',
                ruleValidate: {
                    name: [
                        { required: true, message: '栏目不能为空', trigger: 'blur' }
                    ],
                }
            }
        },
        computed: {
            parent() {
                return this.$store.state.menu.edit.parent;
            }
        },

    }
</script>
