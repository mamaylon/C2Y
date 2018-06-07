<template>
  <section class="todo">
    <hero-component></hero-component>
    <nav-component></nav-component>
    <section id="router-view" class="relative">
      <transition name="fade" mode="out-in">
        <router-view class="view" @error="err"></router-view>
      </transition>
    </section>
    <footer-component></footer-component>
    <bottom-component></bottom-component>
  </section>
</template>

<script>
  import 'vue-toastr/dist/vue-toastr.min.css'
  import 'vue-modal/dist/vue-modal.css'
  import NavComponent from './NavComponent.vue'
  import HeroComponent from './HeroComponent.vue'
  import FooterComponent from './FooterComponent.vue'
  import BottomComponent from './Bottom/Bottom.vue'
  import ModalComponent from './ModalComponent.vue'
  function color (val, old) {
    let color = this.classroom.color
    if (!val) {
      return document.body.style = ''
    }
    document.body.style = `--primary: ${color || 'var(--default)'}`
  }
  export default {
    components: {
      NavComponent,
      HeroComponent,
      FooterComponent,
      BottomComponent,
      ModalComponent
    },
    watch: {
      'classroom.code': color,
      'classroom.color': color
    },
    methods: {
      err (data) {
        console.log(data)
      }
    },
    computed: {
      classroom () {
        return this.$store.getters.classroom
      },
      user () {
        return this.$store.getters.user
      }
    },
    created () {
      this.$toastr.defaultProgressBar = false
      this.$toastr.defaultPosition = 'toast-bottom-right'
    },
    mounted () {
      this.$http.get('/api/notification/' + this.user.id)
        .then(data => {
          this.$store.dispatch('setComments', data.body.data.comments)
          // this.$store.dispatch('setNotifications', data.body.data.notifications)
        })
        .catch(err => this.$toastr.e('Erro ao carregar notificações'))
    }
  }
</script>

<style lang="sass">
  html, body
    overflow: hidden
  #app
    display: flex
    .todo
      display: flex
      flex-direction: column
      flex: 1
    #router-view
      flex: 1
      display: flex
      overflow: auto
</style>
<style lang="sass" scoped>
  .message.box
    width: 70%
    margin: auto
  .message.box .content
    font-weight: 100
    font-size: 1.2rem
    margin-top: 0.5rem
</style>
