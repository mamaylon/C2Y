<template>
  <div class="modal" :class="{'is-active': active}">
    <div class="modal-background"></div>
    <div class="modal-content">
      <slot></slot>
    </div>
    <button v-if="!hideClose" class="modal-close" @click="fn()"></button>
  </div>
</template>

<script>
  export default {
    slots: ['content'],
    props: ['active', 'fn', 'hideClose'],
  }
</script>

<style scoped lang="sass">
  .modal-close
    padding: 1rem
</style>