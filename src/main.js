import Vue from 'vue'
import iView from 'iview';
import App from './App.vue'
import store from './store/index'


Vue.use(iView);




var vm = new Vue({
    el: '#app',
    store,
    render: h => h(App)
});
console.log(vm);