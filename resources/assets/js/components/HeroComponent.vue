<template>
  <!--<nav class="nav has-shadow" id="hero-component">
    <div class="container">
      <div class="nav-left">
        <a class="logo">
         <img src="/images/logos/logo.png" alt="">
        </a>
      </div>
      <div class="nav-right nav-menu">
        <figure class="image nav-item">
          <img src="/images/users/1.jpg" alt="">
        </figure>
      </div>
    </div>
  </nav>-->
  <section id="hero-component">
    <div class="container logo">
      <div class="columns">
        <div class="is-hidden-mobile column is-2">
          <img src="/images/logos/logo.png" alt="">
        </div>
        <div class="column is-offset-5 is-4" id="notification-bar">
          <ul class="nav-list">
            <li>
              <i class="fa fa-bell" aria-hidden="true"></i>
              <span class="tag is-primary">4</span>
            </li>
            <li><i class="fa fa-graduation-cap" aria-hidden="true"></i></li>
            <li>
              <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
              <span class="tag is-primary">48</span>
            </li>
            <li><i class="fa fa-star" aria-hidden="true"></i></li>
          </ul>
        </div>
        <div class="column is-1 is-hidden-mobile">
          <router-link to="/me">
            <img :src="toSize(user.photo, 48)" class="round" alt="">
          </router-link>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  import mixin from '../mixins/index'
  export default {
    mixins: [mixin],
    computed: {
      user: function () {
        return this.$store.getters.user
      }
    }
  }
</script>