<template>
  <section>
    <div class="card">
      <header class="card-header">
        <div class="media">
          <div class="media-left">
            <figure class="image is-32x32">
              <img src="https://bulma.io/images/placeholders/96x96.png" alt="Placeholder image">
            </figure>
          </div>
          <div class="media-content">
            <p class="">John Smith</p>
            <small><time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time></small>
          </div>
        </div>
        <a href="#" class="card-header-icon" aria-label="more options">
          <span class="icon">
            <i class="fa fa-angle-down" aria-hidden="true"></i>
          </span>
        </a>
      </header>
      <div class="card-content">
        <div class="content">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit.
          Phasellus nec iaculis mauris. <a>@bulmaio</a>.
          <a href="#">#css</a> <a href="#">#responsive</a>
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
  mixins: [mixin]
}
</script>

<style lang="sass" scoped>
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

