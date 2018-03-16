<template>
  <section class="root">
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: 0"></div>
    <section class="container" id="teach-component">
      <article class="content" style="position: relative; margin-top: -20px; min-height: 440px; padding-top: 20px; padding-bottom: 20px">
        <section class="columns" v-if="classrooms.length">
          <article class="is-10 is-offset-1 column">
            <!-- <div class="text-medium my-classes">Minhas classes</div> -->
            <div class="grid">
              <section v-for="(item, $index) in classrooms"
                @click="goTo(item)"
                :key="$index">
                <card :item="item"></card>
              </section>
              <section @click="open()">
                <card :fake="true"></card>
              </section>
            </div>
          </article>
        </section>
        <section class="has-text-centered empty ghost" @click="open()" v-else>
          <span>
            <i class="fa fa-users fa-fw fa-5x"></i>
          </span>
          <div class="title">
            Você não possui nenhuma classe.
          </div>
          <div class="subtitle">
            Clique aqui para adicionar sua primeira
          </div>
        </section>
      </article>
    </section>
  </section>
</template>
<script>
  import CourseItemComponent from './Courses/CourseItemComponent.vue'
  import ModalComponent from './ModalComponent.vue'
  import Card from './Classroom/Card.vue'
  import AddClassroom from './Classroom/Modal/AddClassroom.vue'
  import FormClassroom from './Classroom/Modal/FormClassroom.vue'

  export default {
    components: {
      CourseItemComponent,
      ModalComponent,
      Card
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
      goTo (classroom) {
        this.$store.dispatch('classroom', classroom)
        this.$router.replace(`/classroom/${classroom.id}`)
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
  .empty
    height: 70vh
    display: flex
    justify-content: center
    flex-direction: column
  .title, .subtitle
    font-weight: 100
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
