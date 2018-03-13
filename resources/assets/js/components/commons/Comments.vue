<template>
  <article class="media">
    <figure class="media-left">
      <p class="image is-48x48">
        <img src="https://bulma.io/images/placeholders/128x128.png">
      </p>
    </figure>
    <div class="media-content">
      <div class="content">
        <p>
          <strong>John Smith</strong> <small>@johnsmith</small> <small>31m</small>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
        </p>
      </div>
    </div>
    <div class="media-right">
      <a v-tooltip="'Editar comentário'" @click="edit()">
        <i class="fa fa-pencil fa-fw"></i>
      </a>
      <a v-tooltip="'Excluir comentário'" @click="drop()">
        <i class="fa fa-times fa-fw"></i>
      </a>
    </div>
  </article>
</template>

<script>
export default {
  name: 'Comments'
}
</script>

<style lang="sass" scoped>
  .media-right
    i
      font-size: 1.1rem
      -webkit-text-stroke-color: white
      -webkit-text-fill-color: black
      -webkit-text-stroke-width: 2px
      &.fa-pencil
        font-size: 1rem
        -webkit-text-stroke-width: 0
  .image
    border-radius: 3px
  .content
    padding: 0
</style>

