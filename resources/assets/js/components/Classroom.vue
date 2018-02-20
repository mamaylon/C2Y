<template>
  <section>
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: 0"></div>
    <section class="container" id="teach-component">
      <article class="content" style="position: relative; margin-top: -20px; min-height: 440px; padding-top: 20px; padding-bottom: 20px">
        <section class="columns">
          <article class="is-10 is-offset-1 column">
            <!-- <div class="text-medium my-classes">Minhas classes</div> -->
            <div class="grid">
              <section v-for="(item, $index) in classrooms" :key="$index">
                <classroom :item="item"></classroom>
              </section>
              <section @click="open()">
                <classroom :fake="true"></classroom>
              </section>
            </div>
          </article>
        </section>
      </article>
    </section>
  </section>
</template>
<script>
  import CourseItemComponent from './Course/CourseItemComponent.vue'
  import ModalComponent from './ModalComponent.vue'
  import Classroom from './Classroom/Classroom.vue'
  import AddClassroom from './Classroom/Modal/AddClassroom.vue'
  import FormClassroom from './Classroom/Modal/FormClassroom.vue'

  export default {
    components: {
      CourseItemComponent,
      ModalComponent,
      Classroom
    },
    computed: {
      classrooms: function () {
        return this.$store.getters.user.classrooms || []
      }
    },
    methods: {
      open () {
        this.$modal({
          component: AddClassroom,
          onClose: true
        })
      },
      sync (code) {
        let form = {
          user: this.$store.getters.user.id,
          code
        }
        return this.$http.post(`/api/classroom/sync`, form)
      },
      form () {
        this.$modal({
          component: FormClassroom,
          onClose: true
        })
      },
      submit (form) {
        this.$http.post(`/api/classroom`, form)
          .then(data => {
            let classroom = data.body.data.classroom
            classroom.master = this.$store.getters.user
            this.$store.dispatch('push_classroom', classroom)
            return classroom
          })
          .then(this.success)
          .catch(this.error)
      },
      success () {
        this.$modal({
          data: {
            text: 'Sua sala foi criada com sucesso',
            subtext: 'Parabéns pela iniciativa',
            success: true
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
  @media screen and (max-width: 768px)
    .grid
      padding: 1rem
      grid-template-columns: repeat(2, 1fr)
  @media screen and (max-width: 500px)
    .grid
      grid-template-columns: repeat(1, 1fr)
</style>
