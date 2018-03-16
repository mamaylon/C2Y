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
        <!-- Só o dono pode editar, mas os professores e monitores podem excluir se acharem desnecessaria -->
        <div class="menu" v-if="(post.user.id === user.id || admin) && !editing">
          <a v-if="post.user.id === user.id"
            v-tooltip="'Editar publicação'"
            @click="edit()">
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
        <div class="bottom">
          <div class="attachs"></div>
          <a
            class="edit-link"
            @click="toggle()"
            v-if="!editing">
            <template v-if="post.comments_count">
              <i class="fa fa-comments" aria-hidden="true"></i>
              {{ post.comments_count }} comentário{{ post.comments_count > 1 ? 's' : '' }}
            </template>
            <template v-else>
              <i class="fa fa-comments" aria-hidden="true"></i> Seja o primeiro a comentar
            </template>
          </a>
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
      <footer
        class="card-footer comments"
        :class="{'expanded': comments}"
        v-if="comments">
        <template v-if="!loaded">
          <i class="loading fa fa-circle-o-notch fa-2x fa-fw fa-spin"></i>
        </template>
        <template v-else>
          <comments
            @comment="insert"
            :post="post.id"
            :insert="true" />
          <comments
            v-for="comment in arr"
            @drop="dropComment"
            :post="post.id"
            :comment="comment"
            :admin="admin"
            :owner="post.user"
            :key="comment.id"/>
        </template>
      </footer>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/index'
import autosize from 'autosize'
import Comments from '../commons/Comments.vue'
export default {
  name: 'Post',
  props: {
    post: Object,
    admin: Boolean
  },
  components: {
    Comments
  },
  mixins: [mixin],
  data: _ => ({
    editing: false,
    text: '',
    comments: false,
    loaded: false,
    arr: []
  }),
  computed: {
    user: function () {
      return this.$store.getters.user
    }
  },
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
    toggle () {
      this.comments = !this.comments
      if (this.loaded) {
        return
      }
      let params = {
        type: 'post',
        id: this.post.id
      }
      this.$http.get(`/api/comment`, {params})
        .then(resp => {
          if (resp.body.error) {
            throw new Error(resp.body.error)
          }
          this.arr = resp.body.data.comments
          this.loaded = true
        })
        .catch(err => {
          this.comments = false
          this.$toastr.e('Erro ao carregar comentários')
        })
    },
    insert (comment) {
      this.arr.unshift(comment)
      this.post.comments_count++
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
    },
    dropComment (id) {
      this.post.comments_count--
      let index = this.arr.findIndex(it => it.id === id)
      this.arr.splice(index, 1)
    }
  }
}
</script>

<style lang="sass" scoped>
  .bottom
    display: flex
  .attachs
    flex: 1
  a.edit-link
    display: flex
    align-items: center
    justify-content: flex-end
    font-size: .8rem
    &:hover
      color: var(--primary)
      text-decoration: underline
  footer.comments
    --comments: #f5f5f5
    background-color: var(--comments)
    flex-direction: column
    padding-left: 1rem
    .loading
      align-self: center
      padding: 1rem 0
  footer
    // justify-content: flex-end
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
    margin-bottom: .5rem
    padding: 0
</style>

