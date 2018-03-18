<template>
  <form class="card"
    :class="{'wait': wait}"
    @submit.prevent="save">
    <div class="card-content">
      <div class="media">
        <div class="media-left">
          <figure class="image is-48x48">
            <img :src="toSize(user.photo, 48)" alt="Placeholder image">
          </figure>
        </div>
        <div class="media-content">
          <textarea ref="textarea"
            :disabled="wait"
            v-model="text"
            placeholder="O que deseja compartilhar com sua turma?"></textarea>
        </div>
      </div>
    </div>
    <footer class="card-footer">
      <div class="action">
        <a @click="upload">
          <i class="fa fa-link" aria-hidden="true"></i> Adicionar anexo
        </a>
      </div>
      <button class="button is-primary"
        :class="{'is-outlined': !wait}"
        :disabled="wait || text.trim() === ''">
        <i class="fa fa-circle-o-notch fa-spin fa-fw" v-if="wait"></i>
        {{ wait ? 'Publicando' : 'Publicar' }}
      </button>
    </footer>
  </form>
</template>

<script>
import autosize from 'autosize'
import mixin from '../../mixins/index'
import Uploader from '../commons/Uploader.vue'
export default {
  mixins: [mixin],
  mounted () {
    autosize(this.$refs.textarea)
    this.$nextTick(_ => this.upload())
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
    upload () {
      this.$modal({
        component: Uploader,
        onClose: true
      })
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
      this.$toastr.e('Erro ao publicar postagem')
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
    display: flex
    align-items: center
    .action
      flex: 1
      a
        display: inline-flex
        align-items: center
    padding: .5rem
  .card
    margin-bottom: 1rem
    button i
      margin-right: 5px
    &.wait
      filter: brightness(.95)
    .card-content
      padding: 1rem
  textarea
    width: 100%
    border: 0
    resize: vertical
    &:disabled
      background: transparent
  textarea:focus
    outline-style: solid
    outline-width: 0
</style>
