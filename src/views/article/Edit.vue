<template>
    <Form ref="formValidate" :model="formData" :rules="ruleValidate" :label-width="100">


        <Form-item label="文章标题" prop="title">
            <Input v-model="formData.title" />
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
                current_module:'article',
                ruleValidate: {
                    title: [
                        { required: true, message: '文章标题不能为空', trigger: 'blur' }
                    ],
                }
            }
        },

    }
</script>
