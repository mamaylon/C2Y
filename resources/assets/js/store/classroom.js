module.exports = {
  state: {
    classroom: null
  },
  mutations: {
    SET_CLASSROOM (store, payload) {
      store.classroom = payload
    }
  },
  actions: {
    classroom ({commit}, payload) {
      commit('SET_CLASSROOM', payload)
    }
  },
  getters: {
    classroom: state => state.classroom
  }
}