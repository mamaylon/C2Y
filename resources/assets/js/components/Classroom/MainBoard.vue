<template>
  <section class="root">
    <do-post></do-post>
    <post
      v-for="(post, index) in posts"
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
import Post from './Post.vue'
import DoPost from './DoPost.vue'
export default {
  name: 'MainBoard',
  components: {
    Post,
    DoPost
  },
  data: _ => ({
    posts: []
  })
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

