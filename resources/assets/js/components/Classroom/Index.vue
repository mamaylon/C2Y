<template>
  <section
    class="classroom"
    :style="classroom.color ? `--default: ${classroom.color}` : ''">
    <navigator :routes="routes">
      <span v-tooltip.bottom="'Alternar cor do curso'"
        @click="open()"
        class="pointer color-picker"></span>
    </navigator>
    <div class="scroll">
      <article class="container main">
        <side-users :masters="masters" class="aside"></side-users>
        <main-board :admin="admin" class="main"></main-board>
        <side-menu-classroom></side-menu-classroom>
      </article>
    </div>
  </section>
</template>

<script>
  import Navigator from '../commons/Navigator.vue'
  import ColorPicker from './Modal/ColorPicker.vue'
  import SideUsers from './SideUsers.vue'
  import SideMenuClassroom from './SideMenuClassroom.vue'
  import MainBoard from './MainBoard.vue'

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
      Navigator,
      SideUsers,
      SideMenuClassroom,
      MainBoard
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
      admin: function () {
        return this.masters.some(item => item.id === this.user.id)
      },
      masters: function () {
        if (!this.classroom.users) {
          return []
        }
        return this.classroom.users.filter(user => /master|assistant|monitor/ig.test(user.role))
      }
    }
  }
</script>

<style lang="sass" scoped>
  .container.main
    justify-content: center
    > *
      &:nth-child(1)
        flex: 0 1 10%
      &:nth-child(2)
        flex: 0 1 50%
      &:nth-child(3)
        flex: 0 1 30%
  .classroom >>> nav
    margin-bottom: 0
  .scroll
    padding: 1.4rem
    overflow: auto
  .scroll, .classroom
    flex: 1
  .classroom, .container
    display: flex
    flex-direction: column
  .container
    flex-direction: row
  .main
    flex: 1
  .color-picker
    --s: 2rem
    background-color: var(--default)
    border-radius: 50%
    box-shadow: 0 0 3px #ccc 
    height: var(--s)
    width: var(--s)
</style>
