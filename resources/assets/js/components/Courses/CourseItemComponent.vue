<template>
  <div class="card">
    <a class="card-image">
      <figure class="is-square" :class="size || ''">
        <img :src="item && item.photo ? '/upload/' + item.photo : '/images/placeholders/256x256.png'" alt="Image" v-tooltip.auto="item ? item.name : 'O que são algoritmos?'">
        <div class="lock" v-if="lock">
          <i class="fa fa-lock fa-2x fa-fw" aria-hidden="true"></i>
        </div>
        <!-- <a :href="link || '/#/courses/graph'">
        </a> -->
      </figure>
    </a>
    <div v-show="!hide">
      <div>
        <div class="content has-text-centered">
          <strong class="is-primary">{{ item ? item.name : 'O que são algoritmos?' }}</strong> <br>
          <!-- <span v-show="!text">Reputação: <i class="fa fa-star" aria-hidden="true" v-for="i in 5"></i></span> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'CourseItem',
    props: [ 'hide', 'item', 'link', 'size', 'lock' ]
  }
</script>

<style lang="sass" scoped>
  .lock
    display: flex
    color: #333
    justify-content: center
    align-items: center
    background-color: rgba(255, 255, 255, 0.8)
    height: calc(100% + 1px)
    position: absolute
    top: 0
    left: 0
    width: 100%w
  .card
    background: transparent
    box-shadow: none
    border-radius: 0
    margin-bottom: 0
    img
      border-radius: 5px
    .image
      height: 0
    .content
      font-size: 0.8em
      margin-top: 0
      padding-top: 0.1em
</style>