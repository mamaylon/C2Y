<template>
  <section>
    <white-component></white-component>
    <nav class="navbar has-shadow has-border-top" style="margin: -20px 0 20px 0" id="nav-component">
      <form @submit.prevent="submit()" class="container">
        <div class="navbar">
          <i class="fa fa-search fa-2x"></i>
          <p class="control">
            <input class="input" name="name" v-model="form.name" type="text" placeholder="Procurar por cursos">
          </p>
          <div class="navbar-menu">
            <div class="navbar-end">
              <button type="submit" class="button is-primary is-outlined">Pesquisar</button>
              <button type="button" class="button is-outlined" @click="advanced()">Busca avançada</button>
            </div>
          </div>
        </div>
      </form>
    </nav>
    <section class="container">
      <div class="columns">
        <div class="column is-10 is-offset-1">
          <div class="columns"
            v-for="(j, index) in range(0, Math.ceil(courses.length/4))"
            :key="index">
            <!-- to="'/courses/graph/' + courses[i].id" -->
            <article @click="modal(courses[i])"
              class="column is-3"
              v-for="(i, key) in range(j*4, Math.min((j*4)+4, courses.length) )"
              :key="key">
              <course-item-component :item="courses[i]"></course-item-component>
            </article>
          </div>
        </div>
      </div>
    </section>
  </section>
</template>
<script>
  import WhiteComponent from './WhiteComponent.vue'
  import CourseItemComponent from './Courses/CourseItemComponent.vue'
  import NavComponent from './NavComponent.vue'
  import ModalComponent from './ModalComponent.vue'
  import CourseModal from './Courses/CourseModal.vue'
  import AdvancedSearch from './Courses/AdvancedSearch.vue'
  const format = arr => arr.map(item => ({ name: item, selected: false}))

  export default {
    components: {
      NavComponent,
      CourseItemComponent,
      ModalComponent,
      WhiteComponent
    },
    data () {
      return {
        courses: [],
        form: {
          name: ''
        },
        selected: null,
        page: 0,
        types: format(['Plugadas', 'Desplugadas']),
        concepts: format(['Algoritmo', 'Lógica', 'Abstração', 'Decomposição', 'Padrões', 'Avaliação'])
      }
    },
    computed: {
      user () {
        return this.$store.getters.user
      }
    },
    mounted () {
      let self = this
      self.$http.get('/api/course', { params: { user: this.user.id } })
        .then(resp => (self.courses = resp.body.data.courses))
        .catch(err => console.log(err))
    },
    methods: {
      advanced () {
        this.$modal({
          component: AdvancedSearch,
          onClose: true,
          headerFooter: true
        })
      },
      range: (ini, end) =>  _.range(ini, end, 1),
      modal (item) {
        console.log('item', item)
        this.selected = item
        this.$modal({
          component: CourseModal,
          onClose: true,
          headerFooter: true
        })
      },
      close (data) {
        let index = -1
        this.selected = null
        if (!(data && data.id)) return;
        this.courses.find((item, i) => {
          if (item.id == data.id) {
            index = i
            return true
          }
        })
        this.courses.splice(index, 1)
      },
      submit (_data) {
        let self = this
        let data = {}
        for (let i in self.form)
          if (self.form[i] != '' && self.form[i] != 0)        
            data[i] = self.form[i]
        data = _data || data
        data.page = self.page
        self.$http.get('/api/course', { params: data })
          .then(resp => (self.courses = resp.body.data.courses))
          .catch(err => console.log(err))
      }
    }
  }
</script>

<style lang="sass" scoped>
  section.container
    margin-bottom: 30px
  nav
    input:not([type="checkbox"])
      margin-top: 7px
      border: none
      box-shadow: none
      min-width: 50rem
    .container .navbar > *:not(button)
      line-height: 3.25rem
      @extends .lh
      margin-right: 1.7rem
    button
      margin-left: 0.3rem
      transform: translateY(25%)
</style>