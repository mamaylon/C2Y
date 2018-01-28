<template>
  <div class="inline" v-tooltip.left-end="text">
    <router-link :to="route" class="pointer shadow notification" :style="'--color: ' + color" @click="modal = true">
      <i class="fa fa-fw" :class="'fa-' + icon" aria-hidden="true"></i>
    </router-link>
  </div>
</template>

<script>
  export default {
    props: ['route', 'color', 'text', 'icon']
  }
</script>

<style lang="sass" scoped>
  a
    --size: 2.6rem
    box-shadow: 1px 1px 6px 0 #666
    color: white
    background-color: var(--color, tomato)
    height: var(--size)
    width: var(--size)
    float: right
    margin-top: 5px
    display: flex
    align-items: center
    justify-content: center
    border-radius: 50%
    padding: 0 !important
    i
      font-size: 1.5rem
</style>