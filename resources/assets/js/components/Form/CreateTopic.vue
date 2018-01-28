<template>
  <section>
    <article class="">
      <form-component :form="data" :name="'tópico'" :api="'/api/topic'"></form-component>
    </article>
  </section>
</template>

<script>
  import FormComponent from './FormComponent.vue'
  
  let data = [
    {input: 'name', text: 'Nome da tópico'}
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
