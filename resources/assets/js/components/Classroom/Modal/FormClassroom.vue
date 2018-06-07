<template>
  <section class="body">
    <h4 class="title text-medium" v-if="!data">Crie sua classe</h4>
    <h4 class="title text-medium" v-else>Editar sua classe</h4>
    <div>Elit nostrud butcher, keytar trust fund pop-up ennui af kickstarter post-ironic deep v hot chicken ugh.  Leggings adaptogen bitters sapiente tousled umami.</div>
    <form @submit.prevent="submit">
      <div style="margin-top: 10px;">
        <label for="" class="text-medium">Dê um nome para a sua classe</label>
        <input class="input"
          v-validate="'required'"
          :class="{'is-danger': errors.has('nome')}"
          name="nome"
          v-model="form.name"
          placeholder="3º Ano A"
          type="text">
        <span v-show="errors.has('nome')" class="help is-danger">
          {{ errors.first('nome') }}
        </span>
      </div>
      <div style="margin-top: 1rem">
        <label for="" class="text-medium">A qual escola pertence esta classe?</label>
        <input class="input"
          v-validate="'required'"
          :class="{'is-danger': errors.has('escola')}"
          name="escola"
          v-model="form.school"
          placeholder="Escolar Joaquin Timótio"
          type="text">
        <span v-show="errors.has('escola')" class="help is-danger">
          {{ errors.first('escola') }}
        </span>

      </div>
      <div>
        <button type="submit"
          :disabled="form.name === '' || form.school === '' || wait"
          :class="{ 'is-outlined': !wait }"
          class="button is-primary is-fullwidth">
          <i class="fa fa-circle-o-notch fa-fw fa-spin" v-show="wait"></i>
          <template v-if="wait">
            {{ data ? 'Alterando classe' : 'Criando classe' }}
          </template>
          <template v-else>
            {{ data ? 'Alterar classe' : 'Criar classe' }}
          </template>
        </button>
        <button type="button"
          @click="origin.open ? origin.open() : $modal('close')"
          class="button is-outlined is-fullwidth">
          Voltar
        </button>
      </div>
    </form>
  </section>
</template>

<script>
  const def = (data, prop) => data
    ? data[prop] || ''
    : ''
  export default {
    name: 'FormClassroom',
    props: ['origin', 'data'],
    data () {
      return {
        form: {
          name: def(this.data, 'name'),
          school: def(this.data, 'school'),
          user: this.$store.getters.user.id
        },
        wait: false
      }
    },
    methods: {
      submit () {
        this.wait = true
        this.origin.submit(this.form)
      }
    }
  }
</script>

<style lang="sass" scoped>
  input
    border-radius: 0
  .body
    padding: 2em
  button
    margin-top: 0.5rem
    border-radius: calc(2.25rem / 2)
    i
      margin-right: 0.4rem
</style>
