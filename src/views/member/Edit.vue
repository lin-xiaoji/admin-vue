<template>
    <Form ref="formValidate" :model="formData" :rules="ruleValidate" :label-width="100">

        <Form-item label="所属权限组" prop="group_id">
            <Select v-model="formData.group_id">
                <Option v-for="(item,index) in group" :value="item.id" :key="item.id">{{item.name}}</Option>
            </Select>
        </Form-item>

        <Form-item label="帐号" prop="username">
            <Input v-model="formData.username" />
        </Form-item>

        <Form-item label="密码" prop="password">
            <Input v-model="formData.password" type="password" />
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
                currentModule:'member',
                ruleValidate: {
                    username: [
                        { required: true, message: '帐号不能为空', trigger: 'blur' }
                    ],
                }
            }
        },
        computed: {
            group() {
                return this.modalData.group;
            }
        }
    }
</script>
