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
        modalParam:{},
    },
    mutations: {
        modalShow(state, value) {
            state.modalShow = value;
        },
        modalParam(state, param) {
            state.modalParam = param;
        },
        modalComponent(state, component) {
            state.modalComponent = component;
        },
        receiveList(state, data) {
            state[data.module].index = data.data;
        },
        receiveFormData(state, data) {
            state[data.module].edit = data.data;
        },
        remove(state, param) {
            state[param.module].index.list.splice(param.index,1);
        },
    },
    actions: {
        getList(context,param) {
            Api.get(param.module + '/index', {page:param.page}, (data) => {
                context.commit('receiveList', {module:param.module, data});
            });
        },
        getFormData(context,param) {
            Api.get(param.module + '/edit', {id:param.id}, (data) => {
                context.commit('receiveFormData', {module:param.module, data});
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