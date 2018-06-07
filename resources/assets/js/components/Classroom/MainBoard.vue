<template>
  <section class="root">
    <do-post
      v-if="!postable"
      @add="add"></do-post>
    <post
      v-for="(post, index) in posts"
      @delete="remove(index)"
      :post="post"
      :admin="admin"
      :showComments="!!postable"
      :key="index" />
    <div
      class="empty"
      v-if="!posts.length">
      <div>
        <i class="fa fa-file-text" aria-hidden="true"></i>
        Ainda não foram realizadas postagens nessa turma
      </div>
    </div>
  </section>
</template>

<script>
import { mapGetters } from 'vuex'
import Post from './Post.vue'
import DoPost from './DoPost.vue'
export default {
  name: 'MainBoard',
  props: {
    admin: Boolean
  },
  components: {
    Post,
    DoPost
  },
  data: _ => ({
    posts: []
  }),
  computed: {
    classroom () {
      return this.$store.getters.classroom
    },
    postable () {
      return this.$route.params.post
    }
  },
  methods: {
    add (post) {
      this.posts.unshift(post)
    },
    remove(index) {
      this.posts.splice(index, 1)
    }
  },
  mounted () {
    let params = {}
    params.id = this.$route.params.id
    params.type = 'classroom'
    this.$http.get('/api/post' + (this.postable ? '/' + this.postable : ''), { params })
      .then(data => {
        this.posts = data.body.data.posts
      })
      .catch(e => this.$toastr.e('Erro ao carregar publicações'))
  }
}
</script>

<style lang="sass" scoped>
  .root
    margin: 1rem
    margin-top: 0
  .empty
    opacity: .7
    color: black
    margin-top: 2rem
    padding: 1rem
    text-align: center
    font-size: 1.2rem
    > div
      margin: auto
      width: 50%
    i
      font-size: 2rem
      margin: auto
      display: block
</style>

