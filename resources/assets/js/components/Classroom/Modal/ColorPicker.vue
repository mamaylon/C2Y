<template>
  <section>
    <div class="subtitle text-medium">Escolha a cor do curso</div>
    <div class="grid">
      <span
        v-for="(color, index) in colors"
        @click="setColor(color)"
        class="pointer"
        :key="index"
        :class="{ 'is-active': color === active }"
        :style="`--color: ${color}`">
        <span class="relative">
          <i class="fa fa-check fa-fw" v-if="color === active"></i>
        </span>
      </span>
      <span
        @click="setColor(color)"
        :class="{ 'is-active': !active }"
        class="pointer"
        :style="`--color: var(--default)`">
        <span class="relative">
          <i class="fa fa-check fa-fw" v-if="!active"></i>
        </span>
      </span>
    </div>
  </section>
</template>

<script>
  const colors = [
    '#1abc9c',
    '#2ecc71',
    '#3498db',
    '#9b59b6',
    '#34495e',
    '#16a085',
    '#27ae60',
    '#2980b9',
    '#8e44ad',
    '#2c3e50',
    '#f1c40f',
    '#e67e22',
    '#e74c3c',
    '#f39c12',
    '#d35400',
    '#c0392b'
  ]
  export default {
    name: 'ColorPicker',
    data () {
      console.log(this.classroom, this.classroom ? this.classroom.color : '')
      return {
        active: this.classroom ? this.classroom.color : '',
        colors
      }
    },
    methods: {
      setColor (color) {
        this.active = color
        this.$store.dispatch('color', color)
      }
    },
    computed: {
      classroom: function () {
        return this.$store.getters.classroom
      }
    }
  }
</script>

<style lang="sass" scoped>
  .subtitle
    margin-bottom: 1rem
  .grid
    --columns: 7
    --space: .5rem
    & > span
      // border-radius: 50%
      // padding: var(--minus)
      transition: opacity .3s
      opacity: .5
      &:hover
        opacity: .8
      &.is-active
        opacity: 1
        i
          font-size: 1.5rem
          position: absolute
          top: 50%
          left: 50%
          color: white
          transform: translateY(-50%) translateX(-50%)
      &, & span
        display: inline-block
      span
        border-radius: 50%
        --s: calc( (var(--modal-min) - 2.5rem - (var(--columns) * var(--space)) ) / var(--columns) )
        margin-right: var(--space)
        height: var(--s)
        width: var(--s)
        background-color: var(--color, var(--default))
</style>
