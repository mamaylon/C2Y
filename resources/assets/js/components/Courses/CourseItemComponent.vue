<template>
  <div class="card">
    <a class="card-image">
      <figure class="is-square" :class="size || ''">
        <img :src="item.photo != '0' ?( item.photo != null ? makeUrlBlob(item.photo,item.photoType):'/images/placeholders/256x256.png'):'/images/placeholders/256x256.png'" alt="Image" v-tooltip.auto="hide ? item.name : ''">
        <div class="lock" v-if="lock">
          <i class="fa fa-lock fa-2x fa-fw" aria-hidden="true"></i>
        </div>
        <!-- <a :href="link || '/#/courses/graph'">
        </a> -->
      </figure>
    </a>
    <div>
      <div>
        <div class="content has-text-centered">
          <strong class="is-primary">{{ item ? item.name : 'O que são algoritmos?' }}</strong> <br>
          <!-- <span v-show="!text">Reputação: <i class="fa fa-star" aria-hidden="true" v-for="i in 5"></i></span> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'CourseItem',
    props: [ 'hide', 'item', 'link', 'size', 'lock' ],
    methods:{
      makeUrlBlob(base64,type)
      {
        var url = '';
        var blob = null;
        var sliceSize = sliceSize || 512;

        var byteCharacters = atob(base64);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
          var slice = byteCharacters.slice(offset, offset + sliceSize);

          var byteNumbers = new Array(slice.length);
          for (var i = 0; i < slice.length; i++) {
            byteNumbers[i] = slice.charCodeAt(i);
          }

          var byteArray = new Uint8Array(byteNumbers);

          byteArrays.push(byteArray);
        }

        blob = new Blob(byteArrays, {type: type});
        let URL = window.URL || window.webkitURL        
        if (URL && URL.createObjectURL) 
        {
          url = URL.createObjectURL(blob)
        }

        return url;
      }
    }
  }
</script>

<style lang="sass" scoped>
  .lock
    display: flex
    color: #333
    justify-content: center
    align-items: center
    background-color: rgba(255, 255, 255, 0.8)
    height: calc(100% + 2px)
    position: absolute
    top: 0
    left: 0
    width: 100%
  .card
    background: transparent
    box-shadow: none
    border-radius: 0
    margin-bottom: 0
    img
      border-radius: 5px
    .image
      height: 0
    .content
      font-size: 0.8em
      margin-top: 0
      padding-top: 0.1em
</style>
