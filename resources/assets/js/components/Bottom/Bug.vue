<template>
  <div class="box" style="padding: 1.5rem">
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
        <button type="button" @click="submit" class="button is-primary" :disabled="waiting">
          <i class="fa fa-fw fa-circle-o-notch fa-spin" v-if="waiting"></i>
          Enviar
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    methods: {
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
            if (!ret.body.success)
              throw new Error()
            this.$toastr.s('Bug Reportado!')
            this.$modal('close')
          })
          .catch(err => this.$toastr.e('Erro ao reportar o bug. Tente mais tarde ou entre em contato com os desenvolvedores.'))
      }
    },
    data () {
      return {
        waiting: false,
        form: {
          path: '',
          message: '',
          explication: '',
          user: this.$store.getters.user.name
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
