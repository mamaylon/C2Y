<template>
  <section id="teach-component">
    <white-component></white-component>
    <create-prototype></create-prototype>
  </section>
</template>

<script>
  import WhiteComponent from '../WhiteComponent.vue'
  import CreatePrototype from './CreatePrototype.vue'
  export default {
    components: {
      WhiteComponent,
      CreatePrototype
    },
  }
</script>