<template>
  <nav class="navbar has-shadow"
    :class="{ 'classroom': classroom }"
    :style="classroom && classroom.color ? `--default: ${classroom.color}` : ''"
    id="nav-component">
    <div class="container">
      <div class="navbar">
        <span class="navbar-burger" :class="{'is-active': burger}" @click="burger = !burger">
          <span></span>
          <span></span>
          <span></span>
        </span>
        <div class="navbar-menu" :class="{ 'is-active': burger }">
          <nav class="navbar-start">
            <!--<router-link exact to="/" class="nav-item is-tab is-hidden-mobile">Início</router-link>-->
            <router-link to="/material" class="navbar-item">Materiais</router-link>
            <router-link to="/courses" class="navbar-item">Cursos</router-link>
            <!--<router-link to="/learn" class="nav-item is-tab is-hidden-mobile">Aprender</router-link>-->
            <router-link to="/classroom" class="navbar-item">Classes</router-link>
            <!--<a class="nav-item is-tab is-hidden-mobile">Contato</a>-->
            <!--<a class="nav-item is-tab is-hidden-mobile">Blog</a>-->
          </nav>
          <nav class="navbar-end" v-if="classroom">
            <span>Código: {{ classroom.code }}</span>
          </nav>
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
    },
    computed: {
      classroom: function () {
        return this.$store.getters.classroom
      }
    }
  }
</script>

<style scoped lang="sass">
  .navbar
    &:not(.classroom)
      background-color: var(--primary)
    &.classroom
      &, & .navbar
        background-color: var(--default)
    .navbar-end
      span
        display: flex
        align-items: center
        color: white
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

