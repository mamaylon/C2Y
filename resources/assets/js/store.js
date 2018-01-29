module.exports = {  
  state: {
    user: null
  },
  mutations: {
    SET_USER (store, payload) {
      store.user = payload
    }
  },
  actions: {
    user ({commit}, payload) {
      commit('SET_USER', payload)
    }
  },
  getters: {
    user: state => state.user
  }
}