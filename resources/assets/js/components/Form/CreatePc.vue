<template>
  <section style="flex: 1">
    <article class="">
      <form-component :form="data" :name="'componente pensamento computacional'" :api="'/api/pc'"></form-component>
    </article>
  </section>
</template>

<script>
  import FormComponent from './FormComponent.vue'

  let data = [
    {input: 'description', text: 'Nome do componente'}
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
