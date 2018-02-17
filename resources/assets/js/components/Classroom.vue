<template>
  <section>
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: 0"></div>
    <section class="container" id="teach-component">
      <article class="content" style="position: relative; margin-top: -20px; min-height: 440px; padding-top: 20px; padding-bottom: 20px">
        <section class="columns">
          <article class="is-10 is-offset-1 column">
            <!-- <div class="text-medium my-classes">Minhas classes</div> -->
            <div class="grid">
              <class-component v-for="i in 9"></class-component>
              <class-component :fake="true"></class-component>
            </div>
          </article>
        </section>
        <section class="columns">
          <article class="column is-10 is-offset-1">
            <div style="font-weight: bold">Crie sua classe</div>
            <div>Elit nostrud butcher, keytar trust fund pop-up ennui af kickstarter post-ironic deep v hot chicken ugh.  Leggings adaptogen bitters sapiente tousled umami.  In  chicharrones irure, butcher pour-over thundercats helvetica coloring book fanny pack minim kinfolk nisi voluptate.  Veniam irony put a bird on it, church-key photo booth DIY.</div>
            <form @submit.prevent="submit">
              <div style="margin-top: 10px; width: 60%">
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
              <div style="width: 60%; margin-top: 1rem">
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
              <div style="margin-top: 10px">
                <button type="submit"
                  :disabled="form.name === '' || form.school === ''" 
                  class="button is-primary is-outlined">
                  Criar classe
                </button>
              </div>
            </form>
          </article>
        </section>
      </article>
    </section>
  </section>
</template>
<script>
  import CourseItemComponent from './Course/CourseItemComponent.vue'
  import ModalComponent from './ModalComponent.vue'
  import ClassComponent from './Classroom/Class.vue'

  export default {
    components: {
      CourseItemComponent,
      ModalComponent,
      ClassComponent
    },
    data () {
      return {
        form: {
          name: '',
          school: '',
          user: this.$store.getters.user.id
        }
      }
    },
    methods: {
      submit () {
        this.$http.post(`/api/classroom`, this.form)
          .then(this.success)
          .catch(this.error)
      },
      success (resp) {
        this.$modal({
          data: {
            text: 'Sua sala foi criada com sucesso',
            subtext: 'Parabéns pela iniciativa'
          },
          onClose: true,
          timeout: 3000,
          success: true
        })
      },
      error (err) {
        console.log(err)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .my-classes
    font-size: 1.5rem
  .grid
    display: grid
    grid-template-columns: repeat(4, 1fr)
    grid-column-gap: .7rem
    grid-row-gap: .7rem
</style>
