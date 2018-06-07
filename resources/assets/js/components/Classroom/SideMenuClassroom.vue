<template>
  <section>
    <div class="card">
      <header class="card-header">
        <div class="card-header-title">
          <span>Usuários na turma</span>
          <a
            v-if="master"
            @click="assign()">
            <i class="fa fa-cog fa-fw"></i>
          </a>
        </div>
      </header>
      <template v-if="otherUsers.length">
        <div class="card-content grid">
          <router-link
            v-for="user in otherUsers"
            :key="user.id"
            :to="'/user/' + user.id">
            <figure
              class="image is-48x48">
              <img :src="toSize(user.photo, 48)" alt="">
            </figure>
          </router-link>
        </div>
      </template>
      <template v-else>
        <div class="card-content">
          Não há outros usuários nesta turma
        </div>
      </template>
    </div>
    <div class="card">
      <header class="card-header">
        <div class="card-header-title" v-if="classroom.course">
          <span>{{ classroom.course.name }}</span>
          <a
            v-if="master"
            @click="finder()">
            <i class="fa fa-cog fa-fw"></i>
          </a>
        </div>
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
            <div>
              Todos os alunos desta turma estão matriculados para o curso:
            </div>
            <router-link :to="'/courses/graph/' + classroom.course.id">
              {{ classroom.course.name }}
            </router-link>
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
          Seu professor não associou nenhum curso a esta sala de aula.
        </div>
      </template>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/index'
import Finder from './Modal/Finder.vue'
import Board from './Modal/Board.vue'
import Assign from './Modal/Assign.vue'
import { EventBus } from '../../modules/bus'
export default {
  name: 'SideMenuClassroom',
  mixins: [mixin],
  props: {
    users: Array,
    masters: Array
  },
  methods: {
    assign () {
      this.$modal({
        component: Assign,
        data: {
          users: this.users,
          masters: this.masters
        },
        onClose: true
      })
    },
    finder () {
      this.$modal({
        component: Finder,
        onClose: true,
        data: this.classroom.course,
        headerFooter: true
      })
    },
    board () {
      this.$modal({
        component: Board,
        onClose: true,
        data: this.master,
        headerFooter: true,
        data: this.classroom.course
      })
    }
  },
  mounted () {
    EventBus.$on('course:active', data => (this.classroom.course = data))
    // this.$nextTick(_ => this.finder())
  },
  computed: {
    user () {
      return this.$store.getters.user
    },
    classroom () {
      return this.$store.getters.classroom
    },
    otherUsers () {
      return this.users.filter(item => item.id !== this.user.id)
    },
    master () {
      return this.users.some(item => /master/i.test(item.role) && item.id === this.$store.getters.user.id)
    },
  }
}
</script>

<style lang="sass" scoped>
  div.card-header-title
    display: flex
    align-items: center
    > span
      flex: 1
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
