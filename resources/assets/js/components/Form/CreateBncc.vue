<template>
  <section style="flex: 1">
    <article class="">
      <form-component :form="data" :name="'componente da BNCC'" :api="'/api/bncc'"></form-component>
    </article>
  </section>
</template>

<script>
  import FormComponent from './FormComponent.vue'

  let data = [
    {input: 'name', text: 'Nome da bncc'},
    {input: 'cod', text: 'Código da bncc'},
    {input: 'description', text: 'Descrição da bncc'}
  ]

  export default {
    components: {
      FormComponent
    },
    data () {
      return {
        data
      }
    }
  }
</script>

<style lang="sass" scoped>
</style>
