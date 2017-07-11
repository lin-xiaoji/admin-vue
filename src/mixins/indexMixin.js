import Api from '../utils/Api'
import MyPage from '../components/MyPage.vue';
export default {
    data () {
        return {
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
    computed: {
        list() {
            return this.$store.state[this.currentModule].index.list
        },
        total() {
            return this.$store.state[this.currentModule].index.total
        }
    },
    methods: {
        page(page) {
            this.$store.commit('currentPage',{
                module:this.currentModule,
                page:page,
            });
            this.$store.dispatch('getList',{
                module:this.currentModule,
            });
        },
        edit(params) {
            var id = 0;
            if(params.row) {
                id = params.row.id;
            }
            let component = require('../views/'+ this.currentModule +'/Edit.vue');
            this.$store.commit('modalShow',true);
            this.$store.commit('modalComponent',component);
            Api.get(this.currentModule + '/edit', {id:id}, (data) => {
                this.$store.commit('modalData',data);
            });
        },
        remove(params) {
            if (!confirm('确定要删除该数据吗')) {
                return false;
            }
            this.$store.dispatch('remove',{
                module:this.currentModule,
                index:params.index,
                id:params.row.id
            });
        }
    },

    mounted() {
        this.$store.dispatch('getList',{
            module:this.currentModule
        });
    },
    created() {
        if(!this.$store.state[this.currentModule]) {
            if (!this.indexApi) {
                this.indexApi = this.currentModule + '/index'
            }
            this.$store.registerModule(this.currentModule, {
                state: {
                    currentModule:this.currentModule,
                    currentPage:1,
                    indexApi:this.indexApi,
                    index:{},
                }
            });
        }
    },
    components:{
        MyPage
    }
}