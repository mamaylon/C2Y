<template>
  <h1>Classrooooom</h1>
</template>

<script>
  let fromStore = name => {
    return function () {
      return this.$store.getters[name]
    }
  }
  export default {
    name: 'Classroom',
    created () {
      if (this.classroom) {
        return
      }
      let id = this.$route.params.id
      let classroom = this.user.classrooms.find(it => it.id === id)
      this.$store.dispatch('classroom', classroom)
    },
    destroyed () {
      this.$store.dispatch('classroom', null)
    },
    computed: {
      user: fromStore('user'),
      classroom: fromStore('classroom')
    }
  }
</script>
