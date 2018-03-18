<template>
  <section class="container margin-bottom">
    <section class="columns">
      <article class="column is-10 is-offset-1">
        <div class="columns">
          <div class="column is-12">
            <div class="box" style="overflow: hidden" v-if="lesson">
              <div id="panel" class="flex-center" v-if="lesson.source != 'Scratch'">
                <i class="icon-c2y is-dark fa-5x"></i>
                <div>
                  Para completar essa atividade, é necessário que você acesse um link externo.
                  Após completar a atividade, você pode concluí-la clicando no botão "Concluir esta atividade" :)</div>
                <div>
                  <a :href="lesson.link" target="_blank" class="button is-outlined is-primary">Visitar atividade</a>
                  <!-- <router-link v-if="course" :to="'/courses/graph/' + course" class="button is-primary is-outlined">Voltar ao curso</router-link> -->
                </div>
              </div>
              <iframe v-if="lesson.source == 'Scratch'" allowtransparency="true" :src="'//scratch.mit.edu/projects/embed/' + lesson.link_id + '/?autostart=false'" frameborder="0" allowfullscreen></iframe>
              <div id="infos">
                <div class="content">
                  <strong class="strong">{{ lesson.name }}</strong><br>
                  <span v-if="lesson.link">Atividade fornecida por</span> <a :href="lesson.link">{{ lesson.source }}</a>
                  <span>Criada por</span> <a href="#">{{ lesson.user.name }}</a>
                </div>
                <div class="content">
                  {{ lesson.description || 'Nenhuma descrição para essa atividade foi fornecida' }}
                </div>
                <div class="notification" v-show="notify">
                  <button class="delete" @click="notify = false"></button>
                  Seu comentário foi enviado à {{ lesson.user.name }} :D
                </div>
                <div v-show="!notify" class="content">
                  Envie um comentário ao autor:
                  <textarea v-model="body" class="input" placeholder="Digite seu comentário aqui"></textarea>
                  <button class="button is-primary is-outlined" @click="comment">Enviar</button>
                  <a @click="complete" :disabled="lesson.completeds.length > 0" class="button is-success is-outlined">
                    {{ lesson.completeds.length ? 'Atividade concluída' : 'Concluir esta atividade' }}
                  </a>
                </div>
                <div>
                  <router-link v-if="course" :to="'/courses/graph/' + course" class="button is-primary is-outlined">Voltar ao curso</router-link>
                </div>
              </div>
              <slot></slot>
            </div>
          </div>
        </div>
      </article>
    </section>
  </section>
</template>

<script>
  let format = item => {
    if (item.source == 'Scratch')
      item.link_id = item.link.replace('https://scratch.mit.edu/projects/', '').split('/')[0]
    return item
  }
  function load () {
    this.course = this.$route.params.course
    this.$http.get('/api/lesson/' + this.$route.params.id, { params: { user: this.user.id } })
      .then(data => (this.lesson = format(data.body.data.lesson)))
  }
  export default {
    created: load,
    methods: {
      complete () {
        if (this.lesson.completeds.length) {
          return false
        }
        this.$http.post('/api/lesson/complete/' + this.lesson.id, { user: this.user.id })
          .then(data => this.lesson.completeds.push(true))
          .catch(err => console.log(err))
      },
      comment () {
        let data = {
          type: 'lesson',
          id: this.lesson.id,
          body: this.body,
          user: this.user.id,
          receiver: this.lesson.user.id
        }
        this.$http.post('/api/comment', data)
          .then(data => (this.notify = true, this.body = ''))
          .catch(err => console.log(err))
      }
    },
    data () {
      return {
        notify: false,
        lesson: null,
        course: null,
        body: ''
      }
    },
    computed: {
      user () {
        return this.$store.getters.user
      }
    }
  }
</script>

<style scoped lang="sass">
  @import "../../../sass/variables" 
  .notification
    background-color: rgba($primary, 0.1)
  #panel
    & > div
      padding: 3rem
      padding-bottom: 0
    i:before
      color: $dark
  iframe, #panel
    float: left
    margin: -10px 0 0 -10px
    width: 70%
    height: 500px
  #infos
    padding-top: 0.5rem
    max-width: 30%
    float: left
    strong.strong
      font-size: 1.4rem
    textarea
      resize: none
      height: 6rem
      margin-bottom: 0.3rem
  span
    margin: 0 !important
  span:not(:first-of-type)
    display: inline-block
    /* margin: 10px !important */
    /*background-color: tomato;*/
</style>