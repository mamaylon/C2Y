<template>
  <section>
    <div class="card">
      <header class="card-header">
        <div class="media">
          <div class="media-left">
            <figure class="image is-32x32">
              <img :src="toSize(post.user.photo, 48)" alt="Placeholder image">
            </figure>
          </div>
          <div class="media-content">
            <p class="">{{ post.user.name }}</p>
            <small><time :datetime="post.created_at.date">{{ dateToLegible(post.created_at.date || post.created_at) }}</time></small>
          </div>
        </div>
        <div class="menu" v-if="post.user.id === user.id && !editing">
          <a v-tooltip="'Editar publicação'" @click="edit()">
            <i class="fa fa-pencil fa-fw"></i>
          </a>
          <a v-tooltip="'Excluir publicação'" @click="drop()">
            <i class="fa fa-times fa-fw"></i>
          </a>
        </div>
      </header>
      <div class="card-content">
        <form id="submit" @submit.prevent="submit" class="content"
          v-if="editing">
          <textarea class="autosize" ref="textarea" v-model="text"></textarea>
        </form>
        <div class="content" v-else>
          {{ post.text }}
          <br>
        </div>
      </div>
      <footer class="card-footer" v-if="editing">
        <button
          type="button"
          class="button is-outlined"
          @click="clear()">Cancelar</button>
        <button
          :disabled="text.trim() === ''"
          class="button is-outlined is-primary"
          type="submit"
          form="submit">Salvar alterações</button>
      </footer>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/index'
import autosize from 'autosize'
export default {
  name: 'Post',
  props: {
    post: Object
  },
  mixins: [mixin],
  data: _ => ({
    editing: false,
    text: ''
  }),
  methods: {
    submit () {
      this.$http.put(`/api/post/${this.post.id}`, {
        text: this.text
      }).then(data => {
        this.post.text = this.text
        this.clear()
      })
        .catch(err => {
          this.$toastr.e('Erro ao editar publicação')
        })
    },
    clear () {
      this.editing = false
      this.text = ''
    },
    edit () {
      this.editing = true,
      this.text = this.post.text
      console.log(this.$refs)
      this.$nextTick(_ => {
        autosize(this.$refs.textarea)
        this.$refs.textarea.focus()
      })
    },
    drop () {
      if (!confirm('Tem certeza que deseja excluir esta publicação?')) {
        return
      }
      this.$http.delete(`/api/post/${this.post.id}`)
        .then(data => {
          this.$emit('delete')
          this.$toastr.s('Publicação removida')
        })
        .catch(err => this.$toastr.e('Erro ao remover publicação'))
    }
  },
  computed: {
    user: function () {
      return this.$store.getters.user
    }
  }
}
</script>

<style lang="sass" scoped>
  footer
    justify-content: flex-end
    padding: .5rem
    button
      margin-left: .3rem
  .options
    display: inline-block
  .menu
    position: relative
    a
      font-size: 1.4rem
      i
        -webkit-text-fill-color: black
        -webkit-text-stroke-width: 3px
        &.fa-pencil
          padding: .2rem
          font-size: 1rem
          -webkit-text-stroke-width: 0px
        -webkit-text-stroke-color: white
  .card
    margin-bottom: .8rem
  .image
    border-radius: 50%
  .media-content
    height: 100%
    display: flex
    flex-direction: column
    justify-content: center
    p
      line-height: .9rem
  small
    color: #666
    font-size: .8rem
  .media
    flex: 1
    margin: 0 !important
    padding: .8rem
  .content
    padding: 0
</style>

