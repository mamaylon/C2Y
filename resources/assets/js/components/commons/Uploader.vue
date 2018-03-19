<template>
  <section class="box">
    <h4 class="subtitle text-medium">
      <i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i> Anexos
    </h4>
    <div class="grid">
      <div
        v-for="(item, $index) in files"
        :key="$index">
        <div class="item has-text-centered">
          <i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>
        </div>
        <div
          v-if="!item.complete"
          class="hover"
          v-tooltip="'Fazendo upload'">
          <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
        </div>
        <span>{{ item.name }}</span>
      </div>
      <div class="add relative">
        <i class="icon icon-plus fa-fw" aria-hidden="true"></i>
        <input type="file"
          class="pointer"
          @change="change($event.target.files)">
      </div>
    </div>
  </section>
</template>

<script>
import EventBus from '../../modules/bus'
export default {
  name: 'Uploader',
  data: _ => ({
    files: []
  }),
  methods: {
    change (files) {
      if (!files.length)
        return
      let file = files[0]
      let type = file.name.replace(/\w+.(\w+)/i, '$1')
      this.files.push({
        name: file.name,
        complete: false,
        path: null,
        type
      })
      this.post(file)
        .then(data => this.success(data, file))
        .catch(err => this.error(err, file))
    },
    success (data, file) {
      let body = data.body
      let item = this.files.find(it => it.name === file.name)
      item.complete = true
      item.path = body.data.path
    },
    post (file) {
      let form = new FormData()
      form.append('archive', file)
      return this.$http.post('/api/post/upload', form, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
    }
  }
}
</script>

<style lang="sass" scoped>
  .item
    --font: 3rem
    --total: 5rem
    --side: calc(var(--total) - var(--font) - 1.5rem)
    font-size: var(--font)
    background-color: var(--border)
    padding: calc(var(--total) - var(--font)) var(--side)
    line-height: 0
    border-radius: 3px
    box-shadow: 0 0 1px 0px black
  .grid
    display: grid
    grid-template-columns: repeat(5, 1fr)
    grid-gap: .3rem
    > div
      margin-bottom: 2rem
      position: relative
      span, .hover
        position: absolute
        bottom: -1.3rem
        left: 0
        width: 100%
        text-overflow: ellipsis
        white-space: nowrap
        overflow: hidden
      .hover
        display: flex
        align-items: center
        justify-content: center
        top: 0
        left: 0
        height: 100%
        width: 100%
        background: rgba(255, 255, 255, .9)
  .add
    overflow: hidden
    --color: #aaa
    color: var(--color)
    border: 3px dashed var(--color)
    border-radius: 3px
    padding: 2.5rem 0
    i
      position: absolute
      font-size: 3rem
      top: 50%
      left: 50%
      transform: translateY(-50%) translateX(-50%)
    input
      height: 100%
      width: 100%
      opacity: 0
  .subtitle
    i
      margin-right: .3rem
    display: flex
    align-items: center
</style>

