<template>
  <section>
    <div class="user has-text-centered"
      v-for="master in sort"
      :key="master.id">
      <figure class="image is-96x96">
        <img :src="toSize(master.photo, 96)">
      </figure>
      <small>{{ roles[ master.role ].text }}</small>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/index'
const roles = {
  master: {text: 'Professor', value: 3},
  assistant: {text: 'Auxiliar', value: 2},
  monitor: {text: 'Monitor', value: 1},
  student: {text: 'Aluno', value: 0}
}
export default {
  name: 'SideUsers',
  mixins: [mixin],
  props: {
    masters: Array,
    users: Array
  },
  data: () => ({
    roles
  }),
  computed: {
    master () {
      return this.masters.some(it => /master/i.test(it.role) && it.id === this.user.id)
    },
    user () {
      return this.$store.getters.user
    },
    sort () {
      return this.masters.sort((a, b) => {
        return roles[b.role].value - roles[a.role].value
      })
    }
  }
}
</script>

<style lang="sass" scoped>
  .add
    $color: #999
    margin-top: .5rem
    border: 3px dashed $color
    cursor: pointer
    div
      $size: 94px
      color: $color
      height: $size
      width: $size
      font-size: 2rem
      line-height: calc(#{$size} - 3px)
  section
    display: flex
    // background-color: gold
    flex-direction: column
    align-items: flex-end
  .user
    margin-bottom: .5rem
    display: grid
    grid-template-columns: 1fr
  figure
    border-radius: 3px
    overflow: hidden
  small
    line-height: 1rem
    display: block
</style>

