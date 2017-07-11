<template>
    <Form ref="formValidate" :model="formData" :rules="ruleValidate" :label-width="100">


        <Form-item label="分类名称" prop="name">
            <Input v-model="formData.name" />
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
                currentModule:'article_cate',
                ruleValidate: {
                    name: [
                        { required: true, message: '分类名称不能为空', trigger: 'blur' }
                    ],
                }
            }
        },

    }
</script>
