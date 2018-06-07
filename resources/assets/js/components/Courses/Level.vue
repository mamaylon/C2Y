<template>
  <section>
    <div class="level-title media">
      <div class="media-content">
        Fase {{index + 1}}
      </div>
      <div class="media-right">
        <button v-if="edit" class="delete" @click="emit('drop', index)"></button>
      </div>
    </div>
    <article class="grid" style="margin-bottom: 5px">
      <div
        v-for="(item, $index) in level"
        class="relative"
        :key="$index">
        <router-link :to="getLink + item.id" v-if="link && !item.lock">
          <course-item-component :item="item" :lock="item.lock" :size="'is-128x128'" :hide="true"></course-item-component>
        </router-link>
        <course-item-component v-if="!link || item.lock" :lock="item.lock" :item="item" :size="'is-128x128'" :hide="true"></course-item-component>
        <i class="fa fa-times-circle-o close-lesson pointer" aria-hidden="true" v-if="edit" @click="emit('remove', { index, item })"></i>
      </div>
      <div v-if="edit">
        <div class="card create">
          <article class="card-image" @click="emit('add', index)">
            <figure class="is-square ghost">
              <i class="fa fa-plus add" aria-hidden="true"></i>
              <img src="/images/placeholders/256x256.png" style="opacity: 0" alt="Image">
            </figure>
          </article>
        </div>
      </div>
    </article>
  </section>
</template>

<script>
  import CourseItemComponent from './CourseItemComponent.vue'
  export default {
    props: ['level', 'index', 'editable', 'link', 'course'],
    components: {
      CourseItemComponent
    },
    data () {
      return {
        modal: false,
      }
    },
    computed: {
      edit () {
        return (this.editable === undefined || this.editable)
      },
      getLink () {
        if (this.course) {
          return '/courses/' + this.course + '/material/game/'
        }
        return '/material/game/'
      }
    },
    methods: {
      emit (event, data) {
        this.$emit(event, data)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .grid
    display: grid
    grid-template-columns: repeat(5, 1fr)
    grid-gap: .4rem
  .level-title
    font-weight: 700
    border-bottom: thin solid var(--border, tomato)
    margin-bottom: 0.5rem
    text-transform: uppercase
  section
    padding: 0.5rem
  .card.create
    margin-bottom: 0
</style>
