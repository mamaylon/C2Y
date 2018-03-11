<template>
  <section class="root">
    <do-post></do-post>
    <post
      v-for="(post, index) in posts"
      :key="index" />
    
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
</style>

