<template>
    <span>
        <Checkbox-group v-model="privilege.privilege">
            <span v-for="item in list">
                <span v-if="item.level == 2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <span v-if="item.level == 3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <Checkbox :label="item.id">{{item.name}}</Checkbox> <br><br>
            </span>
        </Checkbox-group>
        <Button type="primary" @click="handleSubmit">提交</Button>
    </span>
</template>
<script>
    import indexMixin from '../../mixins/indexMixin';
    import Api from '../../utils/Api'
    export default {
        mixins: [indexMixin],
        data () {
            return {
                current_module:'menu',
            }
        },
        computed: {
            privilege() {
                return this.$store.state.member_group.privilege;
            }
        },
        methods: {
            handleSubmit () {
                Api.post('member_group/privilege?id='+this.privilege.id,{privilege:this.privilege.privilege},(data) =>{
                    this.$Message.success('提交成功!');
                    this.$store.commit('modalShow',false);
                });
            }
        }
    }
</script>
