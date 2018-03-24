<template>
  <section id="teach-component" style="flex: 1">
    <white-component></white-component>
    <section class="columns no-margin">
      <article class="column is-8 is-offset-2 z-index levels" v-if="course">
        <article class="media">
            <figure class="media-left">
              <p class="image relative">
                <img :src="(url ? '/upload/': '') + course.photo" v-if="course.photo">
                <img src="/images/placeholders/128x128.png" v-else>
                <span class="hover pointer">
                  <i class="fa fa-refresh fa-2x fa-fw" aria-hidden="true"></i>
                  <input type="file" @change="changePhoto">
                </span>
              </p>
            </figure>
            <div class="media-content control">
              <input type="text" class="input name" v-model="course.name">
              <div class="content">
                <textarea class="input" v-model="course.description"></textarea>
              </div>
            </div>
            <div class="media-right">
              <!-- <i class="fa fa-trash pointer" aria-hidden="true"></i> -->
              <!-- <i class="fa fa-pencil pointer primary" @click="edit()" aria-hidden="true"></i> -->
            </div>
        </article>
        <div
          v-for="let (f, i) in levels"
          :key="i">
          <level class="item-level" :level="f" @add="addLesson" @push="push" :index="i" @remove="remove" @drop="drop"></level>
        </div>
        <add-level class="add-level" @add="add"></add-level>
        <div class="hidden">
          <button @click="sync" class="button is-outlined is-primary" style="margin-top: 10px; float: right">Finalizar curso</button>
        </div>
      </article>
    </section>
  </section>
</template>

<script>
  import CourseItemComponent from './CourseItemComponent.vue'
  import AddLessonComponent from './AddLessonComponent.vue'
  import WhiteComponent from '../WhiteComponent.vue'
  import AddLevel from './AddLevel.vue'
  import Level from './Level.vue'
  import CourseCreate from './Create.vue'
  import Image from '../../modules/image'
  import CropImage from '../Form/CropImage.vue'

  const watcher = () => {
    return function (curr, old) {
      if (!old || this.info) {
        return false
      }
      this.info = true
    }
  }

  export default {
    mounted () {
      let self = this
      self.$http.get('api/course/' + self.$route.params.id, { params: { user: window.User.id, lessons: true } })
        .then(resp => {
          self.course = resp.body.data.course
          let levels = self.course.lessons.reduce((prev, curr) => {
            let level = curr.pivot.level
            if (!prev[ level ])
              prev[ level ] = []
            prev[ level ].push(curr);
            return prev;
          }, {})
          console.log(levels)
          self.levels = []
          for (let i in levels)
            self.levels.push(levels[i])
        })
    },
    data(){
      return {
        course: null,
        level: null,
        image: null,
        url: true,
        info: false,
        levels: [ [] ]
      }
    },
    watch: {
      'course.description': watcher(),
      'course.name': watcher(),
      'course.photo': watcher()
    },
    components: {
      CourseItemComponent,
      WhiteComponent,
      AddLevel,
      Level
    },
    methods: {
      changePhoto (e) {
        if (this.url) {
          this.url = false
        }
        let vm = this
        Image.load(e, image => {
          vm.image = image
          vm.$modal({
            component: CropImage,
            data: 'course'
          })
        })
      },
      remove (data) {
        let key = -1
        this.levels[data.index].find((item, index) => {
          key = index
          return item == data.item
        })
        this.levels[data.index].splice(key, 1)
      },
      addLesson (data) {
        this.level = data
        this.$modal({
          component: AddLessonComponent,
          onClose: true
        })
      },
      close () {
        this.$modal('close')
      },
      drop (item) {
        this.levels.splice(item, 1)
      },
      add () {
        this.levels.push([])
      },
      push (data) {
        this.levels[this.level].push(data)
      },
      sync () {
        let self = this
        let data = self.levels.reduce((prev, curr, index) => {
          curr.forEach(item => prev.push({level: index, lesson: item.id}))
          return prev
        }, [])
        self.$http.post('/api/course/sync', {
          course: self.course,
          update: self.info,
          lessons: data,
          user: window.User.id
        })
        .then(() => {
          this.$modal({
            data: {
              text: 'Parabéns, você criou um curso :)',
              subtext: 'A comunidade C2Y! agradece seu empenho!',
              success: true
            },
            timeout: 2000,
            onClose: true
          })
          // self.$store.dispatch('message', { text: 'Parabéns, você criou um curso :)<br>A comunidade C2Y! agradece seu empenho!' })
          self.$router.push('/courses')
        })
        .catch(err => self.$modal({ text: 'Um erro ocorreu, volte mais tarde', error: true, onClose: true }))
      }
    }
  }
</script>

<style lang="sass" scoped>
  .image:hover
    .hover
      opacity: 1
  .hover
    height: 100%
    width: 100%
    display: flex
    opacity: 0
    transition: opacity .3s
    align-items: center
    justify-content: center
    position: absolute
    top: 0
    left: 0
    background-color: rgba(white, 0.8)
    input
      cursor: pointer
      position: absolute
      top: 0
      left: 0
      height: 100%
      width: 100%
      opacity: 0
  .media
    margin-bottom: 1rem
    --input: 2.3rem
    --input-m: 0px
  .input:not(:hover):not(:focus)
    border-color: transparent
    box-shadow: none
  .input.name
    height: var(--input)
    margin-bottom: var(--input-m)
    font-family: 'Roboto'
    font-size: 1.5rem
    font-weight: 700
  .image
    width: 12.5vw
    border-radius: 3px
    overflow: hidden
  textarea.input
    transition: all .3s
    height: calc(12.5vw - var(--input-m) - var(--input))
    border-radius: 3px
    &:focus
      border-color: var(--primary)
</style>
