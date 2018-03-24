<template>
  <nav-component>
    <div class="container">
      <div class="navbar-menu">

        <section class="navbar-start">
          <ul>
            <li v-for="(item, index) in routes" :key="index">
              <router-link :to="item.route">
                <i class="fa fa-fw"
                  :class="`fa-${item.icon}`">
                </i>
                <span>
                  {{ item.text }}
                </span>
              </router-link>
              <i class="fa fa-fw fa-chevron-right" v-if="index < routes.length - 1" />
            </li>
          </ul>
        </section>
        <section class="navbar-end">
          <slot></slot>
        </section>

      </div>
    </div>
  </nav-component>
</template>

<script>
  import NavComponent from './NavComponent.vue'
  export default {
    name: 'Navigator',
    components: {
      NavComponent
    },
    props: {
      routes: Array
    }
  }
</script>

<style lang="sass" scoped>
  ul, li
    margin: 0
    padding: 0
  li, a, .navbar-end
    list-style: none
    display: inline-flex
    height: 100%
    align-items: center
    justify-content: center
  a
    &, &:hover, &:active, &:focus
      color: var(--default)
    padding: 0 .5rem
    height: 100%
  .fa-chevron-right
    -webkit-text-stroke-color: white
    -webkit-text-stroke-width: 1px

</style>
