import axios from 'axios'

module.exports = {
  state: {
    user: null
  },
  mutations: {
    SET_USER (store, payload) {
      store.user = payload
    },
    SET_SCHOOL (store, payload) {
      store.user.school = payload
    },
    UPDATE_CLASSROOM (store, payload) {
      let classroom = store.user.classrooms.find(item => item.id === payload.id)
      classroom.name = payload.name
      classroom.school = payload.school
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
    updateClassroom ({ commit, getters }, payload) {
      commit('UPDATE_CLASSROOM', payload)
      commit('UPDATE_ACTIVE_CLASSROOM', getters.user.classrooms.find(it => it.id === payload.id))
    },
    setSchool ({ commit }, { user, school }) {
      commit('SET_SCHOOL', school)
      let params = { school }
      axios.put(`/api/user/${user}`, params)
    },
    push_classroom ({commit}, payload) {
      commit('PUSH_CLASSROOM', payload)
    }
  },
  getters: {
    user: state => state.user
  }
}
