<template>
  <section class="body" style="--modal: 100%">
    <h4 class="subtitle text-medium">Comentários</h4>
    <div class="comments">
      <article
        class="media"
        v-for="comment in data"
        :key="comment.id">
        <figure class="media-left">
          <p class="image is-48x48">
            <img :src="toSize(comment.user.photo, 48)">
          </p>
        </figure>
        <div class="media-content">
          <div class="content">
            <p>
              <strong>{{ comment.user.name }}</strong> <small>{{ dateToLegible(comment.created_at) }}</small>
              <br>
              {{ comment.body }}
            </p>
          </div>
        </div>
        <div class="media-right">
          <a v-tooltip="'Ir para origem'">
            <i class="fa fa-link" aria-hidden="true"></i>
          </a>
          <a
            :class="{'disabled': comment.visualized}"
            :disabled="!comment.visualized"
            @click="visualized(comment)"
            v-tooltip="comment.visualized ? 'Comentário visualizado' : 'Marcar como lida'">
            <i class="fa fa-fw fa-check-circle" aria-hidden="true"></i>
          </a>
        </div>
      </article>
    </div>
  </section>
</template>

<script>
  import mixin from '../../mixins/index'
  export default {
    name: 'CommentsModal',
    mixins: [mixin],
    props: {
      origin: Object,
      data: Array
    },
    methods: {
      visualized (comment) {
        this.$http.put('/api/comment/visualized/' + comment.id)
          .then(data => {
            comment.visualized = true
          })
          .catch(() => this.$toastr.e('Erro ao marcar como visualizado'))
      }
    }
  }
</script>

<style lang="sass" scoped>
  a.disabled
    &, &:hover
      color: var(--primary)
      opacity: .7
      cursor: default
  .body
    padding: 2rem
    padding-right: 0
  .subtitle
    margin-bottom: 1rem
  figure
    overflow: hidden
    border-radius: 3px
  .media
    padding-right: 2rem
  .comments
    max-height: 70vh
    overflow: auto
</style>
