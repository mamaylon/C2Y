module.exports = {
  state: {
    comments: []
  },
  mutations: {
    SET_COMMENTS: (state, payload) => (state.comments = payload)
  },
  actions: {
    setComments ({ commit }, payload) {
      commit('SET_COMMENTS', payload)
    }
  },
  getters: {
    comments: state => state.comments
  }
}
