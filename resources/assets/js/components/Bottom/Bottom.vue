<template>
  <div class="todo">
    <div class="menu">
      <!-- <bug-component></bug-component>  -->
      <link-component :route="'/material/create'" :color="'#22A7F0'" :text="'Cadastrar atividade'" :icon="'puzzle-piece'"></link-component>
      <link-component :route="'/courses/create'" :color="'#3BCEAC'" :text="'Cadastrar curso'" :icon="'graduation-cap'"></link-component>
      <link-component :route="'/material/topic'" :color="'#2C3E50'" :text="'Cadastrar Tema/Assunto'" :icon="'list'"></link-component>
      <link-component :route="'/material/concept'" :color="'#E71D36'" :text="'Cadastrar Conceito'" :icon="'paperclip'"></link-component>
    </div>
    <section class="pointer shadow notification is-success">
      <i class="icon icon-plus fa-2x" aria-hidden="true"></i>
    </section>
  </div>
</template>

<script>
  import BugComponent from './Bug.vue'
  import LinkComponent from './Link.vue'
  export default {
    components: {
      BugComponent,
      LinkComponent
    }
  }
</script>

<style lang="sass" scoped>
  .is-success
    background-color: #07BEB8
  .todo
    --size: 3.5rem
    --bottom: 1.5rem
    --r: 2rem
    z-index: 15
    transition: all .5s
    // background-color: gold
    position: fixed
    right: var(--r)
    bottom: var(--bottom)
    width: calc( var(--size) + 2em )
    min-height: calc( var(--size) + 1em )
    // height: 400px
    overflow: hidden
    display: flex
    align-items: center
    padding: 5px
    justify-content: flex-end
    flex-direction: column
    &:hover, &:active, &:focus
      .menu
        opacity: 1
        max-height: 100vh
  .menu
    // background-color: tomato
    overflow: hidden
    margin-right: 0.1rem
    text-align: center
    max-height: 0
    transition: max-height .5s, opacity .3s
    opacity: 0
  .notification:not(:last-child)
    margin-bottom: 0 !important
  .shadow, .menu /deep/ .shadow
    box-shadow: 1px 1px 6px 0 #666
  section
    height: var(--size)
    width: var(--size)
    display: flex
    align-items: center
    justify-content: center
    border-radius: 50%
    padding: 0 !important
</style>