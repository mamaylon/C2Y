<template>
  <section class="box">
    <h4 class="subtitle text-medium">
      <i class="fa fa-cloud-upload fa-fw" aria-hidden="true"></i> Anexos
    </h4>
    <div class="grid">
      <div>
        <div class="item has-text-centered">
          <i class="fa fa-file-pdf-o fa-fw" aria-hidden="true"></i>
        </div>
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
  methods: {
    change (files) {
      if (!files.length)
        return
      let form = new FormData()
      form.append('archive', files[0])
      this.$http.post('/api/post/upload', form, {
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        onUploadProgress: function( progressEvent ) {
          let perc = parseInt( Math.round( ( progressEvent.loaded * 100 ) / progressEvent.total ) )
          console.log('percentage', perc)
        }.bind(this)
      }).then(function(){
        console.log('SUCCESS!!')
      })
      .catch(function(){
        console.log('FAILURE!!')
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
  .add
    overflow: hidden
    --color: #aaa
    color: var(--color)
    border: 3px dashed var(--color)
    border-radius: 3px
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

