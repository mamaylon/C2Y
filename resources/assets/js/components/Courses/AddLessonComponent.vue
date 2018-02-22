<template>
  <section style="--modal: 75vw">
    <div class="">
      <div class="column is-12">
        <section style="padding: 2em">
          <div style="margin-bottom: 20px">
            <strong>Seleção de novas atividades</strong><br>
            Aute  artisan minim commodo, paleo incididunt chillwave anim.  Affogato kale chips air plant VHS fingerstache fanny pack.  Taxidermy gochujang letterpress, tbh occupy succulents vinyl laborum dolor  proident ex labore.
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
          <div class="columns" v-for="j in range(0, Math.ceil(items.length/6))">
            <article class="column lesson is-2" :class="course == items[i] ? 'is-active' : ''" @click="course = items[i]" v-for="i in range(j*6, Math.min((j*6)+6, items.length))">
              <course-item-component :hide="true" :size="'is-128x128'" :item="items[i]"></course-item-component>
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
  .lesson.is-active img
    border: 2px solid var(--primary, red)
  .modal.is-active
    z-index: 22;
</style>