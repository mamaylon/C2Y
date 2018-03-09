<template>
  <section :style="classroom.color ? `--default: ${classroom.color}` : ''">
    <navigator :routes="routes">
      <span v-tooltip.bottom="'Alternar cor do curso'"
        @click="open()"
        class="pointer color-picker"></span>
    </navigator>



  </section>
</template>

<script>
  import Navigator from '../commons/Navigator.vue'
  import ColorPicker from './Modal/ColorPicker.vue'

  let fromStore = name => {
    return function () {
      return this.$store.getters[name]
    }
  }
  let created = async function () {
    let id = this.$route.params.id
    let classroom = this.user.classrooms.find(it => it.id === id)
    this.$store.dispatch('classroom', classroom)
    this.routes.push({
      icon: 'home',
      text: classroom.name,
      route: `/classroom/${classroom.id}`
    })
    let promise = this.$http.get(`/api/classroom/${classroom.id}`, {
      params: { users: true }
    })
    promise
      .then(result => {
        let data = result.body.data
        this.$store.dispatch('classroom', data.classroom)
      })
      .catch(err => {
        this.err = err
      })
  }

  export default {
    name: 'Classroom',
    created,
    components: {
      Navigator
    },
    data: _ => ({
      routes: [],
      err: null
    }),
    methods: {
      open () {
        let color = this.$store.getters.classroom.color
        let onClose = () => {
          this.$modal('close')
          if (color === this.$store.getters.classroom.color) {
            return
          }
          this.$store.dispatch('color', {
            color: this.$store.getters.classroom.color,
            code: this.$store.getters.classroom.code,
            save: true
          })
        }
        this.$modal({
          component: ColorPicker,
          onClose,
          class: 'min'
        })
      }
    },
    mounted () {
      // this.$nextTick(_ => this.open())
    },
    destroyed () {
      this.$store.dispatch('destroy', null)
    },
    computed: {
      user: fromStore('user'),
      classroom: fromStore('classroom'),
      masters: function () {
        if (!this.classroom.users) {
          return []
        }
        return this.classroom.users.filter(user => user.role === 'master')
      }
    }
  }
</script>

<style lang="sass" scoped>
  .color-picker
    --s: 2rem
    background-color: var(--default)
    border-radius: 50%
    box-shadow: 0 0 3px #ccc 
    height: var(--s)
    width: var(--s)
</style>
