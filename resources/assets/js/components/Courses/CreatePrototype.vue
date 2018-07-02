<template>
  <section>
    <!-- <crop-image @cropped="atualize" :image="image"></crop-image> -->
    <section class="columns no-margin">
      <article class="column is-8 is-offset-2 z-index">
        <strong>{{ title || 'Criar curso' }}</strong>
        <div class="columns">
          <article class="column is-3 has-text-centered">
            <figure class="image is-square">
              <img :src="form.photo ? form.photo : (model ? 'data:image/'+model.photoType+';base64,'+model.photo:'/images/placeholders/256x256.png')">
            </figure>
            <div class="file is-boxed">
              <label v-show="!form.photo" class="file-label">
                <input class="file-input" type="file" @change="change" name="resume">
                <span class="button is-primary is-outlined">
                  <span class="file-icon">
                    <i class="fa fa-upload"></i>
                  </span>
                  <span class="file-label">
                    Selecionar foto...
                  </span>
                </span>
              </label>
              <a id="delImg" v-show="form.photo" @click="form.photo ? form.photo = null : ''" class="button is-danger is-outlined">Remover foto</a>
            </div>
          </article>
          <form class="column is-9">
            <slot @toform="toform"></slot>
            <div v-if="!hide">
              <div class="field">
                <div class="control has-icons-right">
                  <input type="text" v-model="form.name" :class="{ 'is-danger' : error.name }" class="input flat" placeholder="Insira o nome do curso">
                  <span class="icon is-small is-right" v-show="error.name">
                    <i class="fa fa-close"></i>
                  </span>
                </div>
                <p class="help is-danger" v-show="error.name">
                  <span v-for="e in error.name">{{ e }}</span>
                </p>
              </div>
              <div class="field">
                <div class="control">
                  <textarea class="input" :class="{ 'is-danger':error.description }" v-model="form.description" placeholder="Insira a descrição do curso que você quer criar"></textarea>
                </div>
                <p class="help is-danger" v-show="error.description">
                    <span v-for="e in error.description">{{ e }}</span>
                </p>
              </div>
            </div>
            <div class="field">
              <div class="control has-text-right">
                <button type="button" class="button is-success is-outlined" @click="submit">{{ title || 'Criar curso' }}</button>
              </div>
            </div>
          </form>
        </div>
      </article>
    </section>
  </section>
</template>

<script>
  import Image from '../../modules/image'
  import CropImage from '../Form/CropImage.vue'
  import CourseItemComponent from './CourseItemComponent.vue'
  import WhiteComponent from '../WhiteComponent.vue'
  export default {
    components: {
      CourseItemComponent,
      WhiteComponent,
      CropImage
    },
    props: [ 'title', 'hide', 'model', 'api', 'callback'],
    mounted(){

    },
    data () {
      return {
        image: null,
        error: {},
        form: {
          user_id: window.User.id,
          photo: null,
          name: '',
          description: ''
        }
      }
    },
    methods: {
      change (e) { Image.load(e, this.show) },
      next (data) {
        this.$router.replace('/courses/' + data.data.id)
      },
      show (image) {
        this.image = image
        this.$modal({
          component: CropImage
        })
      },
      submit (e) {
        let self = this
        let form = {}
        for (let i in self.form)
          form[i] = self.form[i]

        for (let i in self.model)
        {
          form[i] = !(self.model[i] == null) ? self.model[i] : null

          if(i == "photo")
          {
            if(this.form.photo)
            {
              form[i] = this.form.photo;
            }
          }
        }

        self.$http.post(self.api || '/api/course', form)
          .then(data => {
            self.error = {}
            self.callback ? self.callback(data.body) : self.next(data.body)
          })
          .catch(err => (self.error = err.body, self.$emit('error', err.body)))
      }
    }
  }
</script>

<style lang="sass" scoped>
  .button.is-success.is-outlined
    margin-top: 10px
  figure
    margin-bottom: 0.5rem
  input[type="file"]
    width: 0
  strong
    font-size: 2rem
  textarea
    min-height: 10rem
</style>