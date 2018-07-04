<template>
  <article class="media">
    <figure class="media-left">
      <p class="image is-64x64">
        <img :src="'data:image/'+course.photoType+';base64, '+course.photo" v-if="course.photo != '0' && course.photo != null && course.photo != ''">
        <img src="/images/placeholders/128x128.png" v-else>
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>Descrição do curso: </strong>
          {{ course.description }}
        </p>
      </div>
      <slot name="content"></slot>
      <a v-if="course.likes !== undefined && likable" class="like" @click="$emit(course.liked ? 'unlike' : 'like')" :class="{ 'is-active': course.liked }">
        <i class="fa"
          v-tooltip.top="course.liked ? 'Desmarcar como favorito' : 'Curtir'"
          :class="'fa-heart' + (course.liked ? '' : '-o')"
          aria-hidden="true"></i>
        <span>{{ course.likes }}</span>
      </a>
    </div>
    <div class="media-right">
      <slot name="right"></slot>
    </div>
  </article>
</template>

<script>
  export default {
    props: ['course', 'likable']
  }
</script>

<style lang="sass">
  a.like
    display: inline-flex
    align-items: center
    justify-content: flex-start
    color: var(--black)
    &:hover, &.is-active
      color: var(--primary)
    span
      font-weight: bold
    i
      font-size: 1.35rem
      margin-top: -3px
      margin-right: 0.5em
</style>
