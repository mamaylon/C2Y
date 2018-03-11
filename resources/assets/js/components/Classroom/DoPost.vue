<template>
  <div class="card">
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <figure class="image is-48x48">
            <img :src="toSize(user.photo, 48)" alt="Placeholder image">
          </figure>
        </div>
        <div class="media-content">
          <textarea ref="textarea" placeholder="O que deseja compartilhar com sua turma?"></textarea>
        </div>
      </div>
    </div>
    <footer class="card-footer">
      <button class="button is-outlined is-primary">Publicar</button>
    </footer>
  </div>
</template>

<script>
import autosize from 'autosize'
import mixin from '../../mixins/images'
export default {
  mixins: [mixin],
  mounted () {
    autosize(this.$refs.textarea)
  },
  computed: {
    user () {
      return this.$store.getters.user
    }
  }
}
</script>

<style lang="sass" scoped>
  .image
    border-radius: 3px
  footer
    padding: .5rem
    justify-content: flex-end
  .card
    margin-bottom: 1rem
    .card-content
      padding: 1rem
  textarea
    width: 100%
    border: 0
    resize: vertical
  textarea:focus
    outline-style: solid
    outline-width: 0
</style>
