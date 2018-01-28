<template>
  <div class="inline">
    <section class="pointer notification is-danger" @click="modal = true">
      <i class="fa fa-bug fa-2x fa-fw" aria-hidden="true"></i>
    </section>
    <div class="modal" :class="{'is-active' : modal}">
      <div class="modal-background"></div>
      <div class="modal-content content success box" v-show="waiting">
        <i class="fa fa-circle-o-notch fa-spin fa-5x"></i>
        <h1 class="thin-font">
          Enviando...
        </h1>
      </div>
      <div class="modal-content content success box" v-show="error">
        <i class="fa fa-times-circle fa-5x"></i>
        <h1 class="thin-font">
          BUG não reportado.<br>O servidor de emails está com problemas, tente mais tarde :(
        </h1>
      </div>
      <div class="modal-content content success box" v-show="success">
        <i class="fa fa-check-circle fa-5x"></i>
        <h1 class="thin-font">
          BUG reportado.<br>Obrigado por ajudar :)
        </h1>
      </div>
      <div class="modal-content content box" v-show="!waiting && !success && !error" style="padding: 1.5rem">
        <h4>Reportar bug</h4>
        <div class="field">
          <div class="control">
            <input v-model="form.path" type="text" class="input" placeholder="URL onde o bug aconteceu">
          </div>
        </div>
        <div class="field">
          <div class="control">
            <textarea v-model="form.message" class="textarea" placeholder="Explique o bug encontrado"></textarea>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <textarea v-model="form.explication" class="textarea" placeholder="Se possível, detalhe como foi encontrado o bug"></textarea>
          </div>
        </div>
        <div class="field">
          <div class="control">
            <button type="button" @click="submit" class="button is-primary">Enviar</button>
          </div>
        </div>
      </div>
      <button class="modal-close is-large" @click="clear()"></button>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
      clear () {
        this.error = this.success = false
        this.form.path = ''
        this.form.explication = ''
        this.form.message = ''
        this.modal = false
      },
      submit () {
        let self = this
        let message = `
          O usuário ${self.form.user} reportou um bug na página: ${self.form.path}
          Passo a passo para o erro:
          ${self.form.explication}
          Explicação para o erro:
          ${self.form.message}
        `
        let data = { _subject: 'C2Y! Bug Report', message }
        self.waiting = true
        self.$http.post('https://formspree.io/felipelopesrita@gmail.com', data)
          .then(ret => {
            self.waiting = false
            if (ret.body.success)
              self.success = true
            else
              self.error = true
          })
          .catch(err => (self.waiting = false, self.error = true))
      }
    },
    data () {
      return {
        success: false,
        error: false,
        modal: false,
        waiting: false,
        form: {
          path: '',
          message: '',
          explication: '',
          user: window.User.name
        }
      }
    }
  }
</script>

<style lang="sass" scoped>
  .success
    padding: 4rem 1rem
    display: flex
    align-items: center
    justify-content: center
    i
      width: 5rem
      margin-right: 10px
    i, h1
      display: inline-block;
    h1
      margin: 0 !important
  h4
    font-weight: bold
  section
    --size: 3.2rem
    height: var(--size)
    width: var(--size)
    float: right
    margin-top: 5px
    display: flex
    align-items: center
    justify-content: center
    border-radius: 50%
    padding: 0 !important
    margin: 0 !important
</style>