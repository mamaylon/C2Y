<template>
  <section>
    <div class="main pointer ghost" @click="click">
      <i class="fa fa-plus fa-2x"></i>
      <span class="">Adicionar fase</span>
    </div>
  </section>
</template>

<script>
  export default {
    methods: {
      click () {
        this.$emit('add', {})
      }
    }
  }
</script>

<style lang="sass" scoped>
  .main
    border-radius: 5px
    border: thin dashed #4a4a4a
    padding: 1rem
    display: flex
    align-items: center
    justify-content: center;
  i
    display: inline-block
    margin-right: 0.5rem
    width: auto
  span
    font-weight: 700
    font-size: 1.5rem
    user-select: none
</style>