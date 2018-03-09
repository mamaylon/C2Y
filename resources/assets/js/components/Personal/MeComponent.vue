<template>
  <section
    class="margin-bottom"
    style="flex: 1; min-height: 480px;">
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index:0;"></div>
    <div class="container" id="me-component">
      <div class="columns">
        <div class="is-10 is-offset-1 column">
          <div class="columns">
            <article class="column is-3">
              <figure class="image is-square">
                <img :src="user.photo" class="round" alt="">
              </figure>
              <div style="margin-top: 10px" class="has-text-centered text-medium">
                {{ user.name }}
              </div>
              <div class="has-text-centered">Aluno e professor</div>
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
  var token = window.Laravel.csrfToken
  import PersonaComponent from './PersonaComponent.vue'
  export default {
    components: {
      PersonaComponent
    },
    data () {
      return {
        token,
        user: window.User
      }
    }
  }
</script>
