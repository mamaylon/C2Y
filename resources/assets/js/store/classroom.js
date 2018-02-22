module.exports = {
  state: {
    classroom: {
      color: null
    }
  },
  mutations: {
    SET_CLASSROOM (store, payload) {
      store.classroom = payload
    },
    SET_COLOR (store, payload) {
      if (store.classroom) {
        store.classroom.color = payload
      }
    }
  },
  actions: {
    classroom ({commit}, payload) {
      commit('SET_CLASSROOM', payload)
    },
    color ({commit}, payload) {
      commit('SET_COLOR', payload)
    }
  },
  getters: {
    classroom: state => state.classroom
  }
}