<template>
  <nav class="navbar has-shadow" id="nav-component">
    <div class="container">
      <div class="navbar">
        <span class="navbar-burger" :class="{'is-active': burger}" @click="burger = !burger">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <div class="navbar-menu" :class="{ 'is-active': burger }">
          <!--<router-link exact to="/" class="nav-item is-tab is-hidden-mobile">Início</router-link>-->
          <router-link to="/material" class="navbar-item">Materiais</router-link>
          <router-link to="/courses" class="navbar-item">Cursos</router-link>
          <!--<router-link to="/learn" class="nav-item is-tab is-hidden-mobile">Aprender</router-link>-->
          <router-link to="/classroom" class="navbar-item">Classes</router-link>
          <!--<a class="nav-item is-tab is-hidden-mobile">Contato</a>-->
          <!--<a class="nav-item is-tab is-hidden-mobile">Blog</a>-->
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
  export default {
    data () {
      return {
        burger: false
      }
    }
  }
</script>

<style scoped lang="sass">
  .navbar
    background-color: var(--primary)
    a
      color: white
      opacity: 0.7
      &.navbar-item.is-active
        color: white
        border-bottom-color: white
        opacity: 1
      &:hover
        background-color: rgba(0, 0, 0, 0.2)
</style>

