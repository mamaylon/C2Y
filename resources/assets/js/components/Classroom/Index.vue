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
  let created = function () {
    let id = this.$route.params.id
    // let classroom = this.classroom
    // if (!this.classroom) {
    let classroom = this.user.classrooms.find(it => it.id === id)
    // }
    // Busca no banco
    this.$store.dispatch('classroom', classroom)
    this.routes.push({
      icon: 'home',
      text: classroom.name,
      route: `/classroom/${classroom.id}`
    })
  }

  export default {
    name: 'Classroom',
    created,
    components: {
      Navigator
    },
    methods: {
      open () {
        this.$modal({
          component: ColorPicker,
          onClose: true,
          class: 'min'
        })
      }
    },
    mounted () {
      this.$nextTick(_ => this.open())
    },
    destroyed () {
      this.$store.dispatch('classroom', null)
    },
    data: _ => ({
      routes: []
    }),
    computed: {
      user: fromStore('user'),
      classroom: fromStore('classroom')
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
