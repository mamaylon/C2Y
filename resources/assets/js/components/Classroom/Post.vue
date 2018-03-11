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
            <small><time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time></small>
          </div>
        </div>
        <div class="menu" v-if="post.user.id === user.id">
          <a v-tooltip="'Editar publicação'">
            <i class="fa fa-pencil fa-fw"></i>
          </a>
          <a v-tooltip="'Excluir publicação'" @click="drop()">
            <i class="fa fa-times fa-fw"></i>
          </a>
        </div>
      </header>
      <div class="card-content">
        <div class="content">
          {{ post.text }}
          <br>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import mixin from '../../mixins/images'
export default {
  name: 'Post',
  props: {
    post: Object
  },
  mixins: [mixin],
  methods: {
    drop () {
      this.$http.delete(`/api/post/${this.post.id}`)
        .then(data => this.$emit('delete'))
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

