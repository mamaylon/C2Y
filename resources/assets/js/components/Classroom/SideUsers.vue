<template>
  <section>
    <div
      v-for="i in 6"
      :key="i">
      <div class="user has-text-centered"
        v-for="master in masters"
        :key="master.id">
        <figure class="image is-96x96">
          <img :src="master.photo">
        </figure>
        <small>{{ roles[ master.role ] }}</small>
      </div>
    </div>
  </section>
</template>

<script>
const roles = {
  master: 'Professor',
  assistant: 'Professor auxiliar',
  monitor: 'Monitor',
  student: 'Aluno'
}
export default {
  name: 'SideUsers',
  props: {
    masters: Array
  },
  data: () => ({
    roles
  })
}
</script>

<style lang="sass" scoped>
  .user
    margin-bottom: .5rem
  figure
    border-radius: 3px
    overflow: hidden
  small
    line-height: 0.9rem
    display: block
</style>

