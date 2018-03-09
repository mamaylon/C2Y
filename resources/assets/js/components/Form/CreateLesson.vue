<template>
  <section style="flex: 1">
    <!-- <article class="">
      <form-component :form="data" :name="'atividade'" :api="'/api/lesson'"></form-component>
    </article> -->
    <white-component></white-component>
    <section class="columns message" v-show="success">
      <div class="column is-8 is-offset-2 notification is-success">
        <button type="button" class="delete" @click="success = false"></button>
        Parabéns, você cadastrou um atividade :)
      </div>
    </section>
    <create :title="'Criar atividade'" :api="'/api/lesson'" :hide="true" :model="form" :callback="callback" @error="handle">
      <div class="columns">
        <div class="column is-6">
          <input type="text" name="name" v-model="form.name" class="input flat" :class="{ 'is-danger' : err.name }" placeholder="Nome da atividade">
          <p class="help is-danger" v-show="err.name">
            <span>Campo obrigatório</span>
          </p>
        </div>
        <div class="column is-6">
          <input type="text" name="link" v-model="form.link" class="input flat" placeholder="Link externo para atividade">
        </div>
      </div>
      <div class="columns">
        <div class="column is-6"><input type="number" v-model="form.age" class="input flat" placeholder="Idade indicada (em anos)"></div>
        <div class="column is-6">
          <div class="select is-fullwidth">
            <select v-model="form.topic">
              <option value="" disabled>Tema/Assunto da atividade</option>
              <option v-for="(resp, index) in topics"
                :value="resp.id"
                :key="index">{{ resp.name }}</option>
            </select>
          </div>
        </div>
      </div>
      <div class="columns no-margin-bottom">
        <div class="column is-6 no-padd-bottom">
          <textarea class="input" placeholder="Descrição da atividade" v-model="form.description"></textarea>
        </div>
        <div class="column is-6 no-padd-bottom">
          <div class="select is-fullwidth is-multiple">
            <select v-model="form.concept" multiple="true">
              <option value="" class="option-title" disabled>Conceito da atividade</option>
              <option v-for="(resp, index) in concepts"
                :value="resp.id"
                :key="index">{{ resp.name }}</option>
            </select>
          </div>
        </div>
      </div>
    </create>
  </section>
</template>

<script>
  import Create from '../Courses/CreatePrototype.vue'
  import WhiteComponent from '../WhiteComponent.vue'
    
  export default {
    components: {
      Create,
      WhiteComponent
    },
    mounted () {
      let self = this
      self.$http.get('/api/topic')
        .then(resp => (self.topics = resp.body.data.topics))
      self.$http.get('/api/concept')
        .then(resp => (self.concepts = resp.body.data.concepts))
    },
    methods: {
      handle (err) {
        this.err = err
      },
      callback (data) {
        this.err = {}
        this.$modal({
          data: {
            text: 'Parabéns, você cadastrou uma atividade :)',
            subtext: 'A comunidade C2Y! agradece.',
            success: true
          },
          timeout: 3000,
          onClose: true
        })
        for(let i in this.form)
          Array.isArray(this.form[i]) ? this.form[i] = [] : this.form[i] = null
      }
    },
    data () {
      return {
        form: {
          name: '',
          link: '',
          age: '',
          description: '',
          topic: '',
          concept: [],
        },
        err: {},
        topics: [],
        concepts: [],
        success: false
      }
    }
  }
</script>

<style lang="sass" scoped>
  .columns.message
    margin: 1rem 0 0 0
  .is-multiple select
    height: 10rem
    font-size: 0.8rem
  .option-title
    font-weight: 700
    color: var(--color)
</style>
