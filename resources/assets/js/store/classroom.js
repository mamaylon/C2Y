import axios from 'axios'

const state = () => ({
  color: null,
  code: null
})

module.exports = {
  state: {
    classroom: state()
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
    classroom ({ commit }, payload) {
      commit('SET_CLASSROOM', payload)
    },
    destroy ({ commit }) {
      commit('SET_CLASSROOM', state())
    },
    color ({ commit }, payload) {
      commit('SET_COLOR', payload.color)
      if (!payload.save) {
        return
      }
      let hex = payload.color.replace('#', '')
      axios.post(`/api/classroom/${payload.code}/color/${hex}`)
      commit('SET_CLASS_COLOR', payload)
    }
  },
  getters: {
    classroom: state => state.classroom
  }
}