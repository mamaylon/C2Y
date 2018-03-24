<template>
  <section>
    <div class="margin-left">
      <section class="about">
        <span class="text-medium">Nome:</span> {{ user.name }}<br>
        <div class="text">
          <span class="text-medium">Aniversário:</span> {{ birthday(user.birthday) || 'Desconhecido' }}
          <i v-if="!birthday(user.birthday) && !diff"
            class="fa fa-question-circle question"
            v-tooltip.top="'Verifique as configurações do Google+'"
            aria-hidden="true"></i>
        </div>
        <div style="display: flex; align-items: center">
          <span class="text-medium">Instituição:</span>
          <template v-if="!editing">
            <span
              style="margin-left: .3rem">{{ user.school || 'Desconhecida' }}</span>
            <i
              style="margin-left: .4rem"
              v-if="!diff"
              @click="editing = true"
              class="fa fa-pencil fa-fw pointer" />
          </template>
          <input type="text"
            v-else
            style="margin-left: .3rem"
            v-model="inst"
            @keydown.enter="edit"
            @keydown.esc="edit"
            class="input">
        </div>
        <span class="text-medium">Usuário desde:</span> {{ dateToText(user.created_at) }}<br>
      </section>
      <div class="title-bar">
        <h4 class="subtitle text-medium" v-if="diff">Atividade de {{ firstName(user.name) }}</h4>
        <h4 class="subtitle text-medium" v-else>Minhas atividades</h4>
        <span class="tag is-primary">{{ lessons.length }}</span>
      </div>
      <div
        class="list"
        v-if="lessons.length">
        <router-link
          v-for="lesson in lessons"
          :key="lesson.id"
          :to="'/material/game/' + lesson.id"
          v-tooltip.top="lesson.name">
          <figure
            class="image">
            <img :src="fromURL(lesson.photo)" alt="">
          </figure>
        </router-link>
      </div>
      <div class="empty"
        v-else>
        Você não criou nenhuma atividade até o momento
      </div>
      <div class="title-bar">
        <h4 class="subtitle text-medium" v-if="diff">Cursos de {{ firstName(user.name) }}</h4>
        <h4 class="subtitle text-medium" v-else>Meus cursos</h4>
        <span class="tag is-primary">{{ courses.length }}</span>
      </div>
      <div
        class="list"
        v-if="courses.length">
        <router-link
          v-for="course in courses"
          :key="course.id"
          :to="'/material/game/' + course.id"
          v-tooltip.top="course.name">
          <figure
            class="image">
            <img :src="fromURL(course.photo)" alt="">
          </figure>
        </router-link>
      </div>
      <div class="empty"
        v-else>
        Você não criou nenhum curso até o momento
      </div>
    </div>
  </section>
</template>
<script>
  import mixin from '../../mixins/index'
  import IconPersonaComponent from './IconPersonaComponent.vue'
  import EmptyComponent from '../commons/EmptyComponent.vue'
  import CourseItemComponent from '../Courses/CourseItemComponent.vue'
  import TwitComponent from  './TwitComponent.vue'

  export default {
    components:{
      IconPersonaComponent,
      CourseItemComponent,
      TwitComponent,
      EmptyComponent
    },
    mixins: [mixin],
    props: ['user'],
    created () {
      this.$http.get('/api/me/' + this.user.id)
        .then(data => {
          let body = data.body
          if (body.error)
            throw new Error(body.error)
          this.lessons = body.data.lessons
          this.courses = body.data.courses
        })
        .catch(this.error)
    },
    data () {
      return {
        lessons: [],
        courses: [],
        editing: false,
        inst: this.user.school
      }
    },
    methods: {
      edit () {
        this.$store.dispatch('setSchool', { user: this.user.id, school: this.inst })
        this.inst = ''
        this.editing = false
      },
      error (e) {
        console.log(e)
        this.$toastr.e('Erro ao carregar informações')
      }
    },
    computed: {
      diff () {
        return this.user !== this.$store.getters.user
      },
    }
  }
</script>

<style lang="sass" scoped>
  .input
    max-width: 20rem
  .list
    display: grid
    grid-template-columns: repeat(10, 1fr)
    grid-row-gap: .2rem
    grid-column-gap: .2rem
    .image
      border-radius: 3px
      overflow: hidden
  .subtitle
    margin-top: 1rem
    padding-bottom: 0
    margin-bottom: 0
  .text
    display: flex
    align-items: center
    span
      padding-right: .2rem
  .question
    margin-left: .3rem
    font-size: 1rem
  .title-bar
    display: flex
    padding: 1rem 0 0 0
    align-items: center
    h4
      margin: 0
      margin-right: .5rem
    span
      margin-bottom: -0.3rem
</style>

