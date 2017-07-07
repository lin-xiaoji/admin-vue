import MyPage from '../components/MyPage.vue';
export default {
    data () {
        return {
            list:{},
            total:0,
            operate: [
                {
                    title: '操作',
                    key: 'action',
                    width: 200,
                    align: 'center',
                    render: (h, params) => {
                        let buttons = [
                            h('Button', {
                                props: {
                                    type: 'primary',
                                    size: 'small'
                                },
                                style: {
                                    marginRight: '5px'
                                },
                                on: {
                                    click: () => {
                                        this.edit(params)
                                    }
                                }
                            }, '编辑'),
                            h('Button', {
                                props: {
                                    type: 'error',
                                    size: 'small'
                                },
                                on: {
                                    click: () => {
                                        this.remove(params)
                                    }
                                }
                            }, '删除')
                        ];
                        if(this.operateAdd) {
                            let added = this.operateAdd(h,params);
                            buttons = buttons.concat(added);
                        }
                        return h('div', buttons);
                    }
                }
            ]
        }
    },
    methods: {
        page(page) {
            this.$store.dispatch('getList',{
                module:this.current_module,
                page:page
            });
        },
        edit(params) {
            var id = 0;
            if(params.row) {
                id = params.row.id;
            }
            let component = require('../views/'+ this.current_module +'/Edit.vue');
            this.$store.commit('modalShow',true);
            this.$store.commit('modalParam',{id:id});
            this.$store.commit('modalComponent',component);
        },
        remove(params) {
            if (!confirm('确定要删除该数据吗')) {
                return false;
            }
            this.$store.dispatch('remove',{
                module:this.current_module,
                index:params.index,
                id:params.row.id
            });
        }
    },

    mounted() {
        this.$store.dispatch('getList',{
            module:this.current_module,
            page:1
        });
    },
    created() {
        if(!this.$store.state[this.current_module]) {
            this.$store.registerModule(this.current_module, {
                state: {
                    index:{},
                    edit:{},
                }
            });
        }
    },
    components:{
        MyPage
    }
}