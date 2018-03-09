module.exports = {
  state: {
    user: null
  },
  mutations: {
    SET_USER (store, payload) {
      store.user = payload
    },
    PUSH_CLASSROOM (store, payload) {
      if (!store.user || !store.user.classrooms) {
        return
      }
      store.user.classrooms.push(payload)
    },
    SET_CLASS_COLOR (store, payload) {
      let cl = store.user.classrooms.find(item => item.code === payload.code)
      if (!cl) {
        return
      }
      cl.color = payload.color
    }
  },
  actions: {
    user ({ commit }, payload) {
      commit('SET_USER', payload)
    },
    push_classroom ({commit}, payload) {
      commit('PUSH_CLASSROOM', payload)
    }
  },
  getters: {
    user: state => state.user
  }
}