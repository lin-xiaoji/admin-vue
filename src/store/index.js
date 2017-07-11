import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex);

import login from './modules/login'
import home from './modules/home'
import member_group from './modules/member_group'
import Api from '../utils/Api'

export default new Vuex.Store({

    state: {
        modalShow:false,
        modalComponent:null,
        modalData:{},
    },
    mutations: {
        modalShow(state, value) {
            state.modalShow = value;
        },
        modalData(state, param) {
            state.modalData = param;
        },
        modalComponent(state, component) {
            state.modalComponent = component;
        },
        currentPage(state, data) {
            state[data.module].currentPage = data.page;
        },
        receiveList(state, data) {
            state[data.module].index = data.data;
        },
        remove(state, param) {
            state[param.module].index.list.splice(param.index,1);
        },
    },
    actions: {
        getList(context,param) {
            Api.get(context.state[param.module].indexApi, {page:context.state[param.module].currentPage}, (data) => {
                context.commit('receiveList', {module:param.module, data});
            });
        },
        remove(context,param) {
            Api.get(param.module + '/del?id=' + param.id, {}, () => {
                context.commit('remove', {
                    module: param.module,
                    index: param.index
                });
            });
        }
    },
    modules: {
        login,
        home,
        member_group,
    },

})