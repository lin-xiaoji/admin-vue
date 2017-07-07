import Api from '../../utils/Api'
export default {
    state: {
        menu:[],
        leftMenu:[],
        pageTab: [],
        currTab: -1,
        currNav:0,
    },
    mutations: {
        receiveMenu(state,menu) {
            state.menu = menu;
        },

        setLeftMenu(state,navKey) {
            state.currNav = navKey;
            state.leftMenu = state.menu[navKey].sub;
            state.pageTab = [];
        },


        openPage (state,page) {
            if (!state.pageTab.includes(page)) {
                page.component = require('../../views/'+ page.view +'.vue');
                state.pageTab.push(page);
            }
            state.currTab = state.pageTab.lastIndexOf(page);
        },
        closePage(state,name) {
            state.pageTab.splice(name,1);
            let currTab = name -1;
            if (currTab < 0) currTab = 0;
            state.currTab = currTab
        }
    },
    actions: {
        getMenu(context) {
            Api.post('home/menu', {}, (data) => {
                context.commit('receiveMenu',data);

                context.commit('setLeftMenu',0);
                let page = data[0].sub[0].sub[0];
                context.commit('openPage',page);
            });
        }
    }
}