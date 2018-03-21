<template>
  <section class="box modal-body">
    <article class="">
      <h4 class="subtitle text-medium">Associar curso</h4>
      <span>
        Associando um curso a esta turma, você pode estabelecer prazos para fases e atividades desse curso, além de possuir um "guia" nesta jornada rumo ao aprendizado :)
      </span>
      <form @submit.prevent="search()">
        <div class="field has-addons">
          <div class="control control-input">
            <input
              ref="input"
              v-model="text"
              class="input"
              type="text"
              placeholder="Buscar curso">
          </div>
          <div class="control">
            <a
              :disabled="wait"
              class="button is-primary">
              <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="wait"></i>
              Buscar
            </a>
          </div>
        </div>
      </form>
      <article class="response">
        <div class="empty" v-if="!courses.length">
            <span v-if="!empty">Use a caixa de busca para pesquisar por cursos</span>
            <span v-else>Nenhum curso encontrado buscando por: {{ text }}</span>
          </div>
        </div>
        <template v-else>
          <div
            class="grid">
            <figure
              v-for="(course, i) in courses"
              :key="course.id"
              v-tooltip="course.name"
              @click="active = course"
              :class="active === course ? 'is-active' : ''"
              class="image pointer relative">
              <img :src="fromURL(course.photo)" alt="">
              <i
                v-if="active === course"
                class="fa fa-check-circle fa-fw fa-2x active-item"
                aria-hidden="true"></i>
            </figure>
          </div>
        </template>
      </article>
    </article>
    <footer class="modal-footer">
      <button
        @click="$modal('close')"
        class="button is-outlined">Cancelar</button>
      <button
        @click="sync()"
        class="button is-primary is-outlined"
        :disabled="!active">Associar</button>
    </footer>
  </section>
</template>

<script>
  import mixin from '../../../mixins/index'
	export default {
		name: 'Finder',
    mixins: [mixin],
    data: _ => ({
      text: '',
      wait: false,
      empty: false,
      active: null,
      courses: []
    }),
    mounted () {
      this.$nextTick(_ => this.$refs.input.focus())
    },
    methods: {
      search () {
        if (this.text === '') {
          // return
        }
        let params = { name: this.text }
        this.wait = true
        this.$http.get('/api/course', { params })
          .then(resp => {
            let body = resp.body
            if (body.error) {
              throw new Error(body.error)
            }
            this.empty = !body.data.courses.length
            this.courses = body.data.courses
          })
          .catch(e => {
            this.empty = true
            console.log('error on get api', e)
            this.$toastr.e('Erro ao buscar cursos')
          })
          .then(_ => (this.wait = false))
      },
      sync () {
        let params = {
          classroom: this.$store.getters.classroom.id,
          course: this.active.id
        }
        this.$http.post('/api/classroom/associate', params)
          .then(data => {
            let body = data.body
            if (body.error) {
              throw new Error(body.error)
            }
            this.$modal('close')
          })
          .catch(err => this.$toastr.e('Erro ao associar curso'))
      }
    }
	}
</script>

<style lang="sass" scoped>
  .modal-body > article
    padding: 1.25rem
    padding-bottom: 0
  .modal-footer
    border-top: thin solid var(--border)
    display: flex
    justify-content: flex-end
    padding: 1rem
    button
      margin-left: .4rem
  figure
    border-radius: 3px
    overflow: hidden
    &:not(:hover):not(.is-active)
      opacity: .7
    .active-item
      position: absolute
      top: 50%
      left: 50%
      color: white
      transform: translateX(-50%) translateY(-50%)
    &.is-active:before
      display: block
      content: ''
      position: absolute
      top: 0
      left: 0
      background: rgba(0, 0, 0, .7)
      width: 100%
      height: 100%
  .grid
    display: grid
    grid-template-columns: repeat(7, 1fr)
    grid-gap: .3rem
  .response
    padding: 1rem 0
  form
    margin-top: .5rem
  .box
    padding: 0
    > h4
      margin-bottom: .5rem
    .control-input
      flex: 1
</style>
