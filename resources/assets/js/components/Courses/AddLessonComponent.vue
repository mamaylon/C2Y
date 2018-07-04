<template>
  <section style="--modal: 75vw">
    <div class="">
      <div class="column is-12">
        <section style="padding: 2em">
          <div style="margin-bottom: 20px">
            <strong>Seleção de novas atividades</strong><br>
            Aqui você pode pesquisar as atividades pelo nome e seleciona-las para compor uma fase do curso, após pesquisar selecione a atividade e clique em "concluir".
          </div>

          <form @submit.prevent="submit" action="#" class="columns is-gapless">
            <div class="column is-4">
              <input type="text" v-model="form.name" style="margin-right: -10px" class="input flat" placeholder="Buscar por atividades">              
            </div>
            
            <div class="column is-4" style="margin-left: 5px">
              <button type="submit" class="button is-outlined is-primary">Buscar</button>
              <button type="button" :disabled="!course" @click="push" class="button is-outlined is-success">Concluir</button>              
            </div>
            
          </form>

          <div class="grid">
            <article
              v-for="item in items"
              :key="item.id"
              class="lesson"
              :class="{'is-active': course == item}"
              @click="course = item">
              <course-item-component
                :hide="true"
                :size="'is-128x128'"
                :item="item" />
            </article>
          </div>
        </section>
      </div>
    </div>
  </section>
</template>

<script>
  import CourseItemComponent from './CourseItemComponent.vue'
  export default {
    props: ['origin'],
    components: {
      CourseItemComponent
    },
    data () {
      return {
        course: null,
        items: [],
        form: {
          name: ''
        }
      }
    },
    methods: {
      push () {
        this.course ? this.origin.push(this.course) : false
        this.origin.$modal('close')
      },
      emit (event, data) {
        this.$emit(event, data)
        this.onclose()
      },
      range (ini, end) {
        return _.range(ini, end, 1)
      },
      onclose () {
        this.close()
        this.course = null
        this.form.name = ''
      },
      submit () {
        let self = this
        self.$http.get('/api/lesson/', {params: self.form})
          .then(data => (self.items = data.body.data.lessons))
      }
    }
  }
</script>

<style lang="sass">
  .grid
    display: grid
    grid-template-columns: repeat(6, 1fr)
    grid-gap: .3rem
  .lesson.is-active img
    border: 2px solid var(--primary, red)
  .modal.is-active
    z-index: 22;
</style>
