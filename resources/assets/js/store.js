module.exports = {  
  state: {
    message: null
  },
  mutations: {
    SET_MESSAGE (store, obj) {
      store.message = obj
    }
  },
  actions: {
    message ({commit}, obj) {
      commit('SET_MESSAGE', obj)
    }
  },
  getters: {
    message: state => state.message
  }
}