<template>
  <form class="card" @submit.prevent="save">
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <figure class="image is-48x48">
            <img :src="toSize(user.photo, 48)" alt="Placeholder image">
          </figure>
        </div>
        <div class="media-content">
          <textarea ref="textarea" v-model="text" placeholder="O que deseja compartilhar com sua turma?"></textarea>
        </div>
      </div>
    </div>
    <footer class="card-footer">
      <button class="button is-outlined is-primary"
        :disabled="text.trim() === ''">Publicar</button>
    </footer>
  </form>
</template>

<script>
import autosize from 'autosize'
import mixin from '../../mixins/index'
export default {
  mixins: [mixin],
  mounted () {
    autosize(this.$refs.textarea)
  },
  computed: {
    user () {
      return this.$store.getters.user
    }
  },
  data: _ => ({
    text: '',
    err: null,
    wait: false
  }),
  methods: {
    save () {
      this.wait = true
      let params = {
        type: 'classroom',
        user_id: this.$store.getters.user.id,
        text: this.text,
        id: this.$route.params.id
      }
      this.$http.post(`/api/post`, params)
        .then(resul => {
          resul = resul.body
          resul.error ? this.error(resul.error) : this.success(resul.data.post)
        })
        .catch(this.error)
    },
    clear () {
      this.text = ''
      this.wait = false
      this.$nextTick(_ => autosize.update(this.$refs.textarea))
    },
    success (post) {
      this.$emit('add', post)
      this.clear()
    },
    error (err) {
      this.err = err
      this.wait = false
      // this.clear()
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
