<template>
  <section>
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Alunos da turma
        </p>
      </header>
      <template v-if="students.length">
        <div class="card-content grid">
          <figure
            class="image is-48x48"
            v-for="user in students"
            :key="user.id">
            <img :src="toSize(user.photo, 48)" alt="">
          </figure>
        </div>
      </template>
      <template v-else>
        <div class="card-content">
          Não há alunos nesta turma
        </div>
      </template>
    </div>
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Aplicar curso
        </p>
        <!-- <i class="fa fa-question-circle" aria-hidden="true"></i> -->
      </header>
      <template v-if="false">
        <div class="card-content grid">
          <figure
            class="image is-48x48"
            v-for="user in students"
            :key="user.id">
            <img :src="toSize(user.photo, 48)" alt="">
          </figure>
        </div>
      </template>
      <template v-else>
        <div class="card-content">
          <a
            @click="finder()"
            class="flex">
            <i class="fa fa-link" aria-hidden="true"></i> Escolher curso
          </a>
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/index'
import Finder from './Modal/Finder.vue'
export default {
  name: 'SideMenuClassroom',
  mixins: [mixin],
  props: {
    users: Array
  },
  methods: {
    finder () {
      this.$modal({
        component: Finder,
        onClose: true,
        headerFooter: true
      })
    }
  },
  mounted () {
    this.$nextTick(_ => this.finder())
  },
  computed: {
    students () {
      return this.users.filter(user => /student/i.test(user.role))
    }
  }
}
</script>

<style lang="sass" scoped>
  .card
    margin-bottom: 1rem
  .grid
    padding: 1rem
    display: grid
    grid-template-columns: repeat(4, 1fr)
  figure.image
    overflow: hidden
    border-radius: 3px !important
  .square
    background-color: tomato
    --c: 8rem
    width: var(--c)
    height: var(--c)
    margin-bottom: 1rem
</style>
