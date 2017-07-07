import Api from '../utils/Api'
export default {
    props:{
        id: {
            default: 0
        },
    },
    data() {
        return {
            formData:{}
        };
    },
    methods: {
        handleSubmit (name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    Api.post(this.current_module + '/edit',this.formData,(data) =>{
                        this.$Message.success('提交成功!');
                        this.$store.commit('modalShow',false);
                        this.$store.dispatch('getList',{
                            module:this.current_module,
                            page:1
                        });
                        //清空表单
                        let empty = {};
                        Object.keys(this.formData).map((item)=> {
                            empty[item] = null;
                        });
                        this.formData = empty;
                    });
                } else {
                    this.$Message.error('表单验证失败!');
                }
            });
        },
        getFormData() {
            Api.get(this.current_module + '/edit', {id:this.id}, (data) => {
                if(data.formData) {
                    this.formData = data.formData;
                } else {
                    this.formData = {};
                }
            });
        }
    },
    mounted() {
        this.getFormData();
        this.$watch('id',function () {
            this.getFormData();
        });
    },

}