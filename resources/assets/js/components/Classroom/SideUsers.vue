<template>
  <section>
    <div class="user has-text-centered"
      v-for="master in masters"
      :key="master.id">
      <figure class="image is-96x96">
        <img :src="toSize(master.photo, 96)">
      </figure>
      <small>{{ roles[ master.role ] }}</small>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/images'
const roles = {
  master: 'Professor',
  assistant: 'Professor auxiliar',
  monitor: 'Monitor',
  student: 'Aluno'
}
export default {
  name: 'SideUsers',
  mixins: [mixin],
  props: {
    masters: Array
  },
  data: () => ({
    roles
  })
}
</script>

<style lang="sass" scoped>
  section
    display: flex
    // background-color: gold
    flex-direction: column
    align-items: flex-end
  .user
    margin-bottom: .5rem
  figure
    border-radius: 3px
    overflow: hidden
  small
    line-height: 0.9rem
    display: block
</style>

