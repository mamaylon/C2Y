<template>
  <form class="box" action="#" method="get" @submit.prevent="search(form)">
    <h4>Filtros de pesquisa</h4>
    <div class="field">
      <p class="control">
        <input class="input" v-model="form.name" type="text" placeholder="Pesquisar">
      </p>
    </div>
    <div class="field">
      <p class="control">
        <span class="select is-fullwidth">
          <select v-model="form.concepts">
            <option value="0">Todos os conceitos</option>
            <option :value="item.id" v-for="item in concepts">{{ item.name }}</option>
          </select>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control">
        <span class="select is-fullwidth">
          <select v-model="form.topics">
            <option value="0">Todos os temas </option>
            <option :value="item.id" v-for="item in topics">{{ item.name }}</option>
          </select>
        </span>
      </p>
    </div>
    <div class="field">
      <p class="control">
        <span class="select is-fullwidth">
          <select v-model="form.age">
            <option value="0" disabled>-- Idade --</option>
          </select>
        </span>
      </p>
    </div>
    <div class="field has-text-centered">
      <p class="">
        <button type="submit" class="button is-primary is-outlined">Pesquisar</button>
      </p>
    </div>
  </form>
</template>

<script>
  import Utils from '../../modules/utils'
  export default {
    mounted () {
      let self = this
      self.$http.get('/api/topic')
        .then(data => (self.topics = data.body.data.topics))
      self.$http.get('/api/concept')
        .then(data => (self.concepts = data.body.data.concepts))
    },
    methods: {
      search (form) {
        let self = this
        self.$emit('load', null)
        Utils.submit(form, '/api/lesson', self.$http, 'get')
          .then(data => self.$emit('search', { data: data.body.data.lessons, pages: data.body.data.pages, form, page: 0 }))
      }
    },
    data () {
      return {
        concepts: [],
        topics: [],
        form: {
          name: '',
          concepts: 0,
          age: 0,
          topics: 0
        }
      }
    }
  }
</script>