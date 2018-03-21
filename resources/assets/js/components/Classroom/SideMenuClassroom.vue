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
        <p class="card-header-title" v-if="classroom.course">
          {{ classroom.course.name }}
        </p>
        <p class="card-header-title" v-else>
          {{ master ? 'Aplicar curso' : 'Nenhum curso associado à classe' }}
        </p>
        <!-- <i class="fa fa-question-circle" aria-hidden="true"></i> -->
      </header>
      <template v-if="classroom.course">
        <article class="media">
          <figure class="media-left">
            <p class="image is-48x48">
              <img :src="fromURL(classroom.course.photo)">
            </p>
          </figure>
          <div class="media-content">
            <a
              v-if="master">
              <i class="fa fa-cog" aria-hidden="true"></i> Configurar curso para a classe
            </a>
            <a v-else>
              <i class="fa fa-link" aria-hidden="true"></i> Realizar atividade planejada
            </a>
          </div>
        </article>
        <!-- <div class="card-content">
          <figure
            class="image is-48x48">
            <img :src="fromURL(classroom.course.photo, 48)" alt="">
          </figure>
          <div v-if="master">
            <a
              class="flex">
              <i class="fa fa-cog" aria-hidden="true"></i> Configurar curso para a classe
            </a>
          </div>
          <a v-else>
            <i class="fa fa-link" aria-hidden="true"></i> Realizar atividade planejada
          </a>
        </div> -->
      </template>
      <template v-else>
        <div class="card-content" v-if="master">
          <a
            @click="finder()"
            class="flex">
            <i class="fa fa-link" aria-hidden="true"></i> Escolher curso
          </a>
        </div>
        <div style="padding: 1rem" v-else>
          Seu professor não associou nenhum curso a esta sala de aula ainda.
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
    // this.$nextTick(_ => this.finder())
  },
  computed: {
    classroom () {
      return this.$store.getters.classroom
    },
    students () {
      return this.users.filter(user => /student/i.test(user.role))
    },
    master () {
      return this.users.some(item => /master/i.test(item.role) && item.id === this.$store.getters.user.id)
    },
  }
}
</script>

<style lang="sass" scoped>
  .media-content a
    flex: 1
    display: flex
    align-items: center
  .media
    align-items: center
    padding: 1rem
  figure
    border-radius: 3px
    overflow: hidden
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
