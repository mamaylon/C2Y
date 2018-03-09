<template>
  <section id="teach-component" style="flex: 1">
    <section class="columns no-margin">
      <article class="column is-8 is-offset-2 z-index levels" v-if="course">
        <course-header :course="course" @like="like()" @unlike="unlike()" :likable="true"></course-header>
        <div v-for="(f, i) in levels" :key="i">
          <level :editable="false" :course="course.id" :link="true" class="item-level" :level="f" :index="i"></level>
        </div>
      </article>
    </section>
  </section>
</template>

<script>
  import CourseItemComponent from './CourseItemComponent.vue'
  import CourseHeader from './CourseHeader.vue'
  import WhiteComponent from '../WhiteComponent.vue'
  import ModalComponent from '../ModalComponent.vue'
  import Registry from './Messages/Registry.vue'
  import Level from './Level.vue'

  function init () {
    let self = this
    let data = { lessons: true, user: window.User.id }
    self.$http.get('/api/course/' + self.$route.params.id, { params: data })
      .then(resp => {
        let course = resp.body.data.course
        self.course = course
      })
      .catch(err => this.$modal({
        component: Registry
      }))
  }

  export default {
    components: {
      CourseItemComponent,
      ModalComponent,
      WhiteComponent,
      CourseHeader,
      Level
    },
    methods: {
      range: (ini, end) => _.range(ini, end, 1),
      init,
      like () {
        this.course.liked = true
        this.course.likes += 1
        let data = {
          type: 'course',
          user: window.User.id,
          to: this.course.id
        }
        this.$like(true, data)
          .then(json => (this.course.liked = json))
          .catch(err => {
            this.course.liked = null
            this.course.likes -= 1
          })
      },
      unlike () {
        let data = this.course.liked
        this.course.liked = null
        this.course.likes -= 1;
        this.$like(false, data.id)
          .catch(() => {
            this.course.liked = data
            this.course.likes += 1;
          })
      },
      registry () {
        let self = this
        self.wait = true
        let after = data => {
          if (data.error) return;
          self.wait = false
          self.err = false
          self.init()
        }
        let data = { course: self.$route.params.id, user: window.User.id }
        self.$http.post('/api/course/registry', data).then(after)
      }
    },
    data () {
      return {
        course: null,
        err: false,
        wait: false
      }
    },
    mounted: init,
    computed: {
      levels () {
        if (!this.course || this.course.lessons.length === 0) return []
        let block = false
        let obj = this.course.lessons.reduce((prev, curr) => {
          curr.lock = !curr.completeds
          !prev[ curr.pivot.level ] ? prev[ curr.pivot.level ] = [] : false
          prev[ curr.pivot.level ].push(curr)
          return prev
        }, {})

        obj[0].length ? obj[0][0].lock = false : false
        let arr = []
        let prev = null
        for (let i in obj) {
          if (!obj[i]) continue;
          for (let x = 0; x < obj[i].length; x++) {
            let item = obj[i][x]
            let prev = x > 0 ? obj[i][x-1] : ( i > 0 ? obj[i-1][ obj[i-1].length - 1 ] : null )
            if (!prev) continue;
            if (item.completeds || (!prev.lock && prev.completeds))
              obj[i][x].lock = false
          }

          arr.push(obj[i])
        }
        return arr
      }
    }
  }
</script>

<style scoped lang="sass" scoped="">
  .div-button
    margin-top: 2em
  .box
    width: 50%
    margin: auto
  .levels .media
    margin-bottom: 1rem
</style>
