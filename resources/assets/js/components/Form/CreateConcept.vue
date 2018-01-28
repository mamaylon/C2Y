<template>
  <section>
    <article class="">
      <form-component :form="data" :name="'conceito'" :api="'/api/concept'"></form-component>
    </article>
  </section>
</template>

<script>
  import FormComponent from './FormComponent.vue'
  
  let data = [
    {input: 'name', text: 'Nome do conceito'}
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
