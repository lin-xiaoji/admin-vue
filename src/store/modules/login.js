export default {
    state: {
        status: false
    },
    mutations: {
        loginStatus (state,status) {
            state.status = status;
        }
    }
}