<template>
  <section id="material-component" class="container margin-bottom">
    <div class="notification is-danger" v-show="modal">
      <button type="button" class="delete" @click="modal = false"></button>
      Ocorreu um erro na exclusão do item, tente novamente mais tarde
    </div>
    <div class="columns">
      <div class="column is-10 is-offset-1">
        <div class="container-fluid content">
          <div class="columns">
            <section class="column is-4">
              <filter-component @search="atualize" @load="load"></filter-component>
            </section>
            <section class="column is-8 items">
              <article class="box" id="box">
                <loading-component :message="false" v-if="loading">
                  <item-component :example="true" v-for="i in Math.max(lessons.length, 1)"></item-component>
                </loading-component>
                <empty-component v-show="!lessons.length && !loading" :message="'Nenhuma atividade encontrada'"></empty-component>
                <item-component v-show="!loading && lessons.length > 0" @drop="remove" @error="err" v-for="item in lessons" :item="item"></item-component>
                <paginator-component v-if="pages>1" @paginate="atualize" :form="form" :pages="pages" :page="page"></paginator-component>
              </article>
            </section>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import ItemComponent from './Material/Item.vue'
  import LoadingComponent from './LoadingComponent.vue'
  import EmptyComponent from './EmptyComponent.vue'
  import FilterComponent from './Material/FilterComponent.vue'
  import PaginatorComponent from './Paginator/PaginatorComponent.vue'

  export default {
    mounted () {
      let self = this
      let save = data => {
        self.lessons = data.lessons
        self.pages = data.pages
      }
      self.$http.get('/api/lesson')
        .then(data => (save(data.body.data), self.loading = false))
    },
    methods: {
      load () {
        this.loading = true
      },
      atualize (data) {
        this.loading = false
        this.lessons = data.data
        if (data.form !== undefined)
          this.form = data.form
        if (data.page !== undefined)
          this.page = data.page
        if (data.pages !== undefined)
          this.pages = data.pages
      },
      err (data) {
        this.modal = data
      },
      remove (data) {
        let index = -1,
            self = this
        for (let i in self.lessons) {
          if (self.lessons[i].id == data) {
            index = i
            break;
          }
        }
        self.lessons.splice(index, 1)
      }
    },
    data () {
      return {
        lessons: [],
        form: {},
        pages: 0,
        modal: false,
        loading: true,
        page: 0,
      }
    },
    components: {
      PaginatorComponent,
      ItemComponent,
      FilterComponent,
      EmptyComponent,
      LoadingComponent
    }
  }
</script>

<style lang="sass" scoped>
  .notification
    position: fixed
    bottom: 2rem
    z-index: 6
    max-width: 20%
    right: 2rem
</style>