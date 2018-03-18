<template>
  <section
    v-if="user"
    class="margin-bottom"
    style="flex: 1; min-height: 480px;">
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index:0;"></div>
    <div class="container" id="me-component">
      <div class="columns">
        <div class="is-10 is-offset-1 column">
          <div class="columns">
            <article class="column is-3">
              <figure class="image is-square">
                <img :src="toSize(user.photo, 256)" class="round" alt="">
              </figure>
              <div style="margin-top: 10px" class="has-text-centered text-medium">
                {{ user.name }}
              </div>
              <div class="has-text-centered capitalize">{{ role }}</div>
              <div class="has-text-centered" style="margin-top: 10px">
                <form role="form" action="/logout" method="POST">
                  <input type="hidden" name="_token" :value="token">
                  <input type="submit" value="Sair" class="button is-fullwidth is-primary is-outlined">
                </form>
              </div>
            </article>
            <article class="column is-9 ">
              <persona-component :user="user"></persona-component>
            </article>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<script>
  import PersonaComponent from './Me/PersonaComponent.vue'
  import mixin from '../mixins/index'
  export default {
    components: {
      PersonaComponent
    },
    mixins: [mixin],
    data: _ => ({
      token: window.Laravel.csrfToken
    }),
    computed: {
      user () {
        return this.$store.getters.user
      },
      role () {
        let role = []
        if (!this.user.classrooms.some(it => it.master.id === this.user.id))
          role.push('aluno')
        if (this.user.classrooms.some(it => it.master.id === this.user.id))
          role.push('professor')
        return role.reduce((prev, curr, index) => {
          prev += (index === role.length - 1)
            ? (index ? ', ' : ''  ) + curr
            : ' e ' + curr
          return prev
        }, '')
      }
    }
  }
</script>

<style lang="sass" scoped>
</style>

