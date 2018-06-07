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
    {input: 'description', text: 'Nome da bncc'}
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
