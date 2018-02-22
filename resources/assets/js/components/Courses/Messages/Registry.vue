<template>
  <section class="box">
    Você ainda não está matriculado neste curso. Deseja matricular-se neste momento?
    <div class="div-button has-text-centered">
      <button class="button is-outlined is-primary" :disabled="origin.wait" @click="origin.registry()">Sim, quero me cadastrar agora</button>
    </div>
  </section>
</template>
<script>
  export default {
    props: ['origin'],
    name: 'Registry'
  }
</script>

<style lang="sass" scoped>
  .button
    margin-top: 1em;
  .box
    box-shadow: none !important;
    width: 50%;
    margin: auto;
</style>

