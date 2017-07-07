<template>
    <div class="login-bd"><div class="login-logo">  </div>
        <h3>管理后台登陆</h3>
        <Form ref="formInline" :model="formInline" :rules="ruleInline">
            <Form-item prop="username">
                <Input type="text" v-model="formInline.username" placeholder="请输入帐号"/>
            </Form-item>
            <Form-item prop="password">
                <Input type="password" v-model="formInline.password" placeholder="请输入密码" />
            </Form-item>
            <Form-item>
                <Button type="primary" @click="handleSubmit('formInline')" long>登录</Button>
            </Form-item>
        </Form>
    </div>

</template>
<script>
    import Api from '../utils/Api'
    import Cookie from '../utils/Cookie'
    export default {
        data () {
            return {
                formInline: {
                    username: '',
                    password: ''
                },
                ruleInline: {
                    username: [
                        { required: true, message: '请填写用户名', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请填写密码', trigger: 'blur' },
                        { type: 'string', min: 3, message: '密码长度不能小于3位', trigger: 'blur' }
                    ]
                }
            }
        },
        methods: {
            handleSubmit(name) {
                this.$refs[name].validate((valid) => {
                    if(valid) {
                        let that = this;
                        Api.post('login/login',this.$data.formInline,function (data) {
                            Cookie.set('login_id',data.id,2);
                            Cookie.set('username',data.username,2);
                            Cookie.set('token',data.token,2);
                            that.$store.commit('loginStatus',true);
                        });
                    }
                });
            }
        }
    }
</script>
