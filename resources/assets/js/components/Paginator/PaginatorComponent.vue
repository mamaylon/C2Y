<template>
  <section class="has-text-centered">
    <div class="field has-addons">
      <p class="control">
        <a class="button" :disabled="page == 0" @click="paginate(page-1)">
          <span class="icon is-small">
            <i class="fa fa-caret-left" aria-hidden="true"></i>
          </span>
          <!-- <span>Left</span> -->
        </a>
      </p>
      <p class="control" v-for="p in range(Math.max(1, page-1), Math.min(page+3 + (page-2 < 0 ? (page-2)*-1 : 0), pages))">
        <a class="button" @click="paginate(p - 1)" :class="{ 'is-active is-primary': p - 1 === page }">
          <!-- <span class="icon is-small">
             <i class="fa fa-align-center"></i> 
          </span> -->
          <span>{{ p }}</span>
        </a>
      </p>
      <p class="control">
        <a class="button" :disabled="page == pages-1" @click="paginate(page+1)">
          <span class="icon is-small">
            <i class="fa fa-caret-right" aria-hidden="true"></i>
          </span>
          <!-- <span>Right</span> -->
        </a>
      </p>
    </div>
  </section>
</template>

<script>
  import Utils from '../../modules/utils'
  export default {
    props: ['pages', 'page', 'form'],
    methods: {
      range (begin, end) {
        let offset = begin > end ? end : begin
        let delta = Math.abs(end - begin)
        let result = []
        for (let i = 0; i <= delta; i++)
          result.push(i + offset)
        return result
      },
      paginate (page) {
        if (page < 0 || page >= this.pages)
          return false
        let self = this
        self.form.page = page
        Utils.submit(self.form, '/api/lesson', self.$http, 'get')
          .then(data => self.$emit('paginate', { data: data.body.data.lessons, page }))
      }
    }
  }
</script>

<style lang="sass" scoped>
  .field
    justify-content: center
    padding-top: 2rem
</style>