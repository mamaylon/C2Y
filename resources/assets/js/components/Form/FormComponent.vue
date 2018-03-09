<template>
  <form
    :action="api"
    @submit.prevent="submit"
    method="POST"
    style="flex: 1"
    class="content box column is-6 is-offset-3">
    <div class="notification is-success" v-show="modal">
      <button type="button" class="delete" @click="modal = false"></button>
      Informações salva com sucesso :)
    </div>
    <div class="notification is-danger" v-show="error">
      <button type="button" class="delete" @click="error = false"></button>
      Ocorreram erros durante o salvamento das informações :(
      <ul>
        <div v-for="(err, index) in error" :key="index">
          <li v-for="(e, key) in err" :key="key">
            {{ e }}
          </li>
        </div>
      </ul>
    </div>
    <h3>Cadastrar {{ name }}</h3>
    <div class="field"
      v-for="(item, index) in form"
      :key="index">
      <div class="file" v-if="item.file">
        <label v-show="!form.image" class="file-label">
          <input type="file" @change="change" :name="item.input">
          <span class="button file-button is-outlined" :class="data[ item.input ] ? 'is-info' : 'is-primary'">
            <span class="file-icon">
              <i class="fa fa-upload"></i>
            </span>
            <span class="file-label">
              {{ !data[ item.input ] ? 'Selecionar foto...' : 'Trocar de foto...' }}
            </span>
          </span>
        </label>
      </div>
      <div class="control" v-if="!item.file">
        <input v-if="!item.api" v-model="data[ item.input ]" :name="item.input" class="input flat" type="text" :placeholder="item.text">
        <span v-if="item.api && item.api.multiple">{{ item.text }}</span>
        <div v-if="item.api" class="select is-fullwidth" :class="{ 'is-multiple' : item.api.multiple }">
          <select v-model="data[ item.input ]" :multiple="item.api.multiple">
            <option value="0" disabled v-if="!item.api.multiple">{{ item.text }}</option>
            <option v-for="(resp, key) in apiData[ item.input ]"
              :value="resp.id"
              :key="key">{{ resp[ item.api.field ] }}</option>
          </select>
        </div>
      </div>
    </div>
    <div class="field">
      <div class="control">
        <button @click="submit" type="button" class="button is-primary">Cadastrar</button>
        <button type="reset" class="button is-danger is-outlined">Limpar campos</button>
      </div>
    </div>
  </form>
</template>

<script>
  import Utils from '../../modules/utils'
  export default {
    props: ['form', 'name', 'api'],
    methods: {
      change (e) {
        let files = e.target.files || e.dataTransfer.files
        if (!files.length)
          return
        this.name = e.target.name
        this.createImage(files[0], e.target.name)
      },
      createImage (file, field) {
        let reader = new FileReader()
        let self = this
        reader.onload = (e) => {
          self.data[ field ] = e.target.result
        }
        reader.readAsDataURL(file)
      },
      submit () {
        let self = this
        Utils.submit(self.data, self.api, self.$http, 'post')
          .then(data => (data.body.error ? (self.modal = false, self.error = data.body.error) : (self.modal = true, self.error = false)))
          .catch(err => (self.modal = false, self.error = err.body))
      }
    },
    mounted () {
      let self = this
      self.form.forEach(input => {
        if (!input.api)
          return false
        self.$http.get('/api/' + input.api.route)
          .then(data => {
            self.data[ input.input ] = input.api.multiple ? [] : '0'
            self.apiData[ input.input ] = data.body.data[ input.api.route + 's' ]
          })
      })
    },
    data () {
      let data = { user_id: window.User.id }
      this.form.forEach(item => (data[ item.input ] = item.api && item.api.multiple ? [] : ''))
      return {
        modal: false,
        error: false,
        apiData: {},
        data
      }
    }
  }
</script>

<style lang="sass" scoped>
  h3
    margin: 1rem 0 1rem 0.5rem
  .field
    padding-right: 30%
    padding-left: 0.5rem
  .button:not(.file-button)
    margin: 1rem 0
  form
    margin-bottom: 2rem
</style>