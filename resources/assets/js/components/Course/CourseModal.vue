<template>
  <section class="box" v-if="course">
    <article class="columns">
      <article class="column is-12">
        <course-header :course="course">
          <nav class="level is-mobile" slot="content">
            <div class="level-left">
              <div class="level-item primary">
                <span class="icon is-small" v-if="course.likes > 0"><i class="fa fa-heart"></i></span>&nbsp;
                <small v-if="course.likes === 1">Uma pessoa gostou desse curso</small>
                <small v-if="course.likes > 1">{{ course.likes }} pessoas gostaram desse curso</small>
              </div>
            </div>
          </nav>
          <div slot="right">
            <span v-if="course.student" class="text-success">
              <i v-show="!wait" class="fa fa-check-circle-o" v-tooltip.auto-start="'Matriculado no curso'"></i>
            </span>
            <span v-if="user.id == course.user_id">
              <a v-show="!wait" v-tooltip="'Excluir este curso'" href="#" class="fa fa-trash text-danger" @click.prevent="drop"></a>
              <a v-show="!wait" v-tooltip="'Editar curso'" @click="goTo('/courses/' + course.id)" class="fa fa-pencil"></a>
              <i v-show="wait" v-tooltip="'Carregando...'" class="fa fa-circle-o-notch fa-spin fa-1x fa-fw wait"></i>
            </span>
          </div>          
        </course-header>
      </article>
    </article>
    <article class="columns">
      <article class="column is-12 has-text-right">
        <button :disabled="wait" class="button is-outlined" @click="close()">Cancelar</button>
        <button v-if="!course.student" :disabled="wait" class="button is-primary is-outlined" @click="submit()">
          Fazer este curso
        </button>
        <a v-if="course.student" @click="goTo('/courses/graph/' + course.id)" class="button is-primary is-outlined">
          Ir para o curso
        </a>
      </article>
    </article>
  </section>
</template>

<script>
  import CourseHeader from './CourseHeader.vue'
  export default {
    props: ['origin'],
    methods: {
      goTo (route) {
        this.origin.$modal('close')
        this.origin.$router.push(route)
      },
      close (data) {
        this.origin.$modal('close')
      },
      drop () {
        if (!confirm('Tem certeza que deseja excluir este curso?'))
          return false
        let self = this
        self.wait = true
        self.$http.delete('/api/course/' + self.course.id, { params: { user: self.user.id } })
          .then(data => {
            if (data.error) return;
            self.close({ id: self.course.id })
            self.wait = false
          })
      },
      submit () {
        let self = this
        let after = data => {
          if (data.error) return;
          self.wait = false
          self.course.student = true
        }
        self.wait = true
        let data = { course: self.course.id, user: self.user.id }
        self.$http.post('/api/course/registry', data).then(after)
      }
    },
    data () {
      return {
        user: window.User,
        wait: false,
        course: this.origin.selected
      }
    },
    components: {
      CourseHeader
    }
  }
</script>

<style lang="sass" scoped>
  .wait
    opacity: 0.7
  .modal-content
    width: 50%
    .columns
      margin-left: 0 !important
      margin-right: 0 !important
</style>