<template>
  <section>
    <div class="margin-left">
      <section class="about">
        <span class="text-medium">Nome:</span> {{ user.name }}<br>
        <div class="text">
          <span class="text-medium">Aniversário:</span> {{ birthday || 'Desconhecido' }}
          <i v-if="!birthday"
            class="fa fa-question-circle question"
            v-tooltip.top="'Verifique as configurações do Google+'"
            aria-hidden="true"></i>
        </div>
        <span class="text-medium">Instituição:</span> UFSCar Sorocaba<br>
        <span class="text-medium">Usuário desde:</span> {{ dateToText(user.created_at) }}<br>
      </section>
      <h4 class="subtitle text-medium">Minhas atividades</h4>
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
      <h4 class="subtitle text-medium">Meus cursos</h4>
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
    data: _ => ({
      lessons: [],
      courses: []
    }),
    methods: {
      error (e) {
        console.log(e)
        this.$toastr.e('Erro ao carregar informações')
      }
    },
  }
</script>

<style lang="sass" scoped>
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
</style>

