<template>
  <section :class="{ 'padd' : !hide }">
    <i class="icon-c2y" :style="'--size: ' + (size || '5rem')" v-show="!hide"></i>
    <span class="">{{ message }}</span>
  </section>
</template>

<script>
  export default {
    props: ['message', 'hide', 'size'],
    data () {
      let self = this
      return {
        font: self.size || '4em'
      }
    }
  }
</script>

<style lang="sass" scoped>
  section.padd
    padding: 4rem 0
    align-items: center
  section
    display: flex
    justify-content: center
    flex-direction: column
  i
    display: block
    font-size: var(--size, 4em)
    margin-bottom: 0.3rem
  i:before
    color: #aaa
  span
    font-size: 1rem
</style>