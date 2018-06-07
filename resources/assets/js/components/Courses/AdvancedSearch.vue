<template>
  <form @submit.prevent="submit()">
    <section class="body">
      <div class="title-box">Busca avançada de cursos</div>
      <div class="field">
        Buscar por:
        <div class="control has-icons-left">
          <input class="input" type="text" placeholder="Digite aqui sua busca" v-model="origin.form.name">
          <span class="icon is-small is-left">
            <i class="fa fa-search"></i>
          </span>
        </div>
      </div>
      <article class="subtitle-box">
        <div>Atividades do tipo: </div>
        <span v-for="(item, index) in types"
          :key="index"
          class="tag no-select"
          :class="{ 'is-primary': item.selected }"
          @click="item.selected = !item.selected">
          {{ item.name }}
        </span>
      </article>
      <article class="subtitle-box">
        <div>Conceitos: </div>
        <span v-for="(item, index) in concepts"
          :key="index"
          class="tag no-select"
          :class="{ 'is-primary': item.selected }"
          @click="item.selected = !item.selected">
          {{ item.name }}
        </span>
      </article>
    </section>
    <div class="modal-footer">
      <button class="button" type="button" @click="close()">Cancelar</button>
      <button class="button is-primary is-outlined">Pesquisar</button>
    </div>
  </form>
</template>

<script>
  export default {
    name: 'AdvancedSearch',
    props: ['origin'],
    methods: {
      close () {
        this.origin.$modal('close')
      },
      submit() {
        let data = {}
        data.name = this.origin.form.name
        data.types = this.types.filter(x => x.selected).map(x => x.name)
        data.concepts = this.concepts.filter(x => x.selected).map(x => x.name)
        this.origin.submit(data)
        this.$modal('close')
      }
    },
    data () {
      return {
        types: this.origin.types,
        concepts: this.origin.concepts
      }
    }
  }
</script>

<style lang="sass" scoped>
  .body, .modal-footer
    padding: 1.25rem
  .body
    padding: 2rem
  .modal-footer
    display: flex
    border-top: thin solid var(--border)
    justify-content: flex-end
    .button
      margin-left: 5px
  .title-box
    font-weight: 700
    font-size: 1.3rem
  .tag
    cursor: pointer
    border-radius: 0.3rem
    padding: 1rem 0.5rem
    margin-bottom: 5px
    margin-right: 5px
  article
    margin-bottom: .5rem
</style>
