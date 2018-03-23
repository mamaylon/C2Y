<template>
  <article class="media" :class="{'wait' : commenting}">
    <figure class="media-left">
      <p class="image is-32x32">
        <img
          :src="toSize(comment.user.photo, 48)"
          v-if="!insert">
        <img
          :src="toSize(user.photo, 48)"
          v-else>
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <template v-if="!insert && !editing">
          <strong>{{ comment.user.name }}</strong> <small>{{ dateToLegible(comment.created_at) }}</small>
          <br>
          <div v-html="comment.body.replace(/\n/g, '<br>')"></div>
        </template>
        <textarea
          :disabled="commenting"
          @keydown.enter.prevent="() => { return false }"
          @keydown.ctrle="ctrl = true"
          @keyup.ctrle="ctrl = false"
          @keyup.enter="submit()"
          ref="textarea"
          v-model="comment_text"
          v-else></textarea>
      </div>
    </div>
    <div class="media-right">
      <template v-if="!insert && !editing">
        <a
          v-if="comment.user.id === user.id"
          v-tooltip="'Editar comentário'"
          @click="edit()">
          <i class="fa fa-pencil fa-fw"></i>
        </a>
        <a
          v-if="deletePermission"
          v-tooltip="'Excluir comentário'"
          @click="drop()">
          <i class="fa fa-times fa-fw"></i>
        </a>
      </template>
      <template v-else>
        <i class="fa fa-fw no-thin pointer"
          :class="commenting ? 'fa-circle-o-notch fa-spin' : 'fa-question-circle'"
          v-tooltip="commenting ? 'Postando seu comentário' : 'Ctrl+Enter: Nova linha<br>Enter: Comentar'"
          aria-hidden="true"></i>
      </template>
    </div>
  </article>
</template>

<script>
import mixin from '../../mixins/index'
import autosize from 'autosize'
export default {
  name: 'Comments',
  mixins: [mixin],
  props: {
    comment: Object,
    owner: Object,
    insert: Boolean,
    post: Object
  },
  mounted () {
    this.$nextTick(_ => autosize(this.$refs.textarea))
  },
  data: _ => ({
    ctrl: false,
    comment_text: '',
    commenting: false,
    editing: false
  }),
  computed: {
    user () {
      return this.$store.getters.user
    },
    deletePermission () {
      return this.comment.user.id === this.user.id
        || this.owner.id === this.user.id
        || this.admin
    }
  },
  methods: {
    submit () {
      if (this.ctrl) {
        this.comment_text += '\n'
        return this.$nextTick(_ => autosize.update(this.$refs.textarea))
      }
      let text = this.comment_text.trim()
      if (text === '') {
        return
      }
      this.commenting = true
      let data = {
        user: this.user.id,
        type: 'post',
        id: this.post.id,
        receiver: this.post.user.id,
        body: text
      }
      let route = '/api/comment' + (this.editing ? '/' + this.comment.id : '')
      this.$http[ this.editing ? 'put' : 'post' ](route, data)
        .then(resp => (this.editing ? this.successEdit : this.success)(resp))
        .catch(this.error)
    },
    successEdit (resp) {
      let data = resp.body
      if (data.error) {
        return this.error(data.error)
      }
      this.reset()
      this.editing = false
      this.comment.body = this.comment_text
      this.comment_text = ''
    },
    success (resp) {
      let data = resp.body
      if (data.error) {
        return this.error(data.error)
      }
      this.reset()
      this.comment_text = ''
      this.$nextTick(_ => autosize.update(this.$refs.textarea))
      this.$emit('comment', data.data.comment)
    },
    drop () {
      if (!confirm('Tem certeza que deseja excluir este comentário?')) {
        return
      }
      this.$http.delete(`/api/comment/${this.comment.id}`)
        .then(() => {
          this.$emit('drop', this.comment.id)
          this.$toastr.s('Comentário excluído')
        })
        .catch(err => this.$toastr.e('Erro ao excluir comentário'))
    },
    edit () {
      this.comment_text = this.comment.body
      this.editing = true
      this.$nextTick(_ => {
        autosize(this.$refs.textarea)
        this.$refs.textarea.focus()
      })
    },
    error (err) {
      this.reset()
      this.$toastr.e('Erro ao ' + (this.editing ? 'editar' : 'postar') + ' comentário')
      this.editing = false
    },
    reset () {
      this.commenting = false
    }
  }
}
</script>

<style lang="sass" scoped>
  .media.wait
    opacity: .9
    filter: brightness(.95)
  .media-right
    i:not(.no-thin)
      font-size: 1.1rem
      -webkit-text-stroke-color: var(--comments)
      -webkit-text-fill-color: black
      -webkit-text-stroke-width: 2px
      &.fa-pencil
        font-size: 1rem
        -webkit-text-stroke-width: 0
  textarea
    height: 1rem
    padding: .5rem
    resize: vertical
    width: 100%
    border: thin solid var(--border)
    border-radius: 3px
  .image
    border-radius: 3px
  .content
    padding: 0
</style>

