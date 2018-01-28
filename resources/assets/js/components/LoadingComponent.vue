<template>
  <section :class="{ 'message': message }">
    <div v-if="message">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <slot></slot>
  </section>
</template>

<script>
  export default {
    props: ['message']
  }
</script>

<style lang="sass" scoped>
  section.message
    background-color: tomato
</style>
