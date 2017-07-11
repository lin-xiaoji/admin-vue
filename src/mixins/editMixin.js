import Api from '../utils/Api'
export default {
    props:['modalData'],
    data() {
        return {
            formData:{}
        }
    },
    watch: {
        modalData: function (newData) {
            this.formData = newData.formData;
            if (newData.formData) {
                this.formData = newData.formData;
            } else  {
                this.formData = {}
            }
        }
    },

    methods: {
        handleSubmit (name) {
            this.$refs[name].validate((valid) => {
                if (valid) {
                    Api.post(this.currentModule + '/edit',this.formData,(data) =>{
                        this.$Message.success('提交成功!');
                        this.$store.commit('modalShow',false);
                        this.$store.dispatch('getList',{
                            module:this.currentModule
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
        }
    }

}