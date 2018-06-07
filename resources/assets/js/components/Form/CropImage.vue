<template>
  <section>
    <div class="has-text-centered">
      <vue-croppie 
          ref=croppie 
          :enableOrientation="true">
      </vue-croppie>
      <button class="button is-primary" @click="crop">Cortar Imagem</button>
      <button class="button is-outlined is-primary" @click="close(null)">Cancelar</button>
    </div>
    <button class="modal-close is-large" @click="close(null)"></button>
  </section>
</template>

<script>
  export default {
    props: ['origin', 'data'],
    mounted () {
      this.$refs.croppie.bind({
        url: this.origin.image
      })
    },
    methods: {
      close (data) {
        let middle = this.data || 'form'
        this.origin[middle].photo = data
        this.origin.image = null
        this.origin.$modal('close')
      },
      crop () {
        let options = { format: 'jpeg' }
        this.$refs.croppie.result(options, output => this.close(output));
      }
    }
  }
</script>

<style lang="sass">
  input[type=range]::-webkit-slider-thumb
    background: var(--primary)
  .cr-boundary
    padding-left: 1em
    padding-right: 1em
    border-radius: 3px
</style>

<style lang="sass" scoped>
  section
    padding: 1rem
  .modal-close
    &:before, &:after
      background-color: var(--dark)
  .modal-background
    background-color: rgba(255, 255, 255, 0.7)
</style>