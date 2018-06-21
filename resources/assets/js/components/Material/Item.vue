<template>
  <article class="media" id="item-component">
    
    <div class="is-hidden-tablet">
      
      <router-link :to="'/material/game/' + item.id">
        <figure class="image">
          <img :src="item.photo!= '0' ? makeUrlBlob(item.photo,item.photoType): '/images/placeholders/128x128.png'" alt="">
        </figure>
      </router-link>
      
      <div class="has-text-centered">
        {{ item.name }}
      </div>

    </div>
    
    <figure class="media-left is-hidden-mobile">
      <p class="image is-64x64">
        <router-link :to="'/material/game/' + item.id">
          <img :src="item.photo!= '0'  ? makeUrlBlob(item.photo,item.photoType): '/images/placeholders/128x128.png'">
        </router-link>
      </p>
    </figure>

    <div class="media-content is-hidden-mobile">
      <div class="content">
        <p>
          
          <router-link :to="'/material/game/' + item.id">
            <strong v-if="!example">{{ item.name }}</strong> 
          </router-link>

          <small v-if="!example && item.link">Disponível por <a :href="item.link">{{ item.source }}</a></small>
          <br>
          <span v-if="!example">
            Tema Pensamento Computacional: 
              <em>
                <span v-for="c in item.pc_components"> {{ c.name }}; </span>
                <span v-show="!item.pc_components.length">Sem conceitos cadastrados.</span><br>
              </em>
            BNCC: 
              <em>
                <span v-for="c in item.bncc_components"> {{ c.name }}; </span>
                <span v-show="!item.bncc_components.length">Sem conceitos cadastrados.</span><br>
              </em>
            Idade Sugerida: 
              <em>
                {{ item.age_min +' a '+ item.age_max + " anos" }}<br>
              </em>
          </span>
        </p>
      </div>
      <!--<nav class="level is-mobile">
        <div class="level-left">
          <a class="level-item">
            <span class="icon is-small"><i class="fa fa-reply"></i></span>
          </a>
          <a class="level-item">
            <span class="icon is-small"><i class="fa fa-retweet"></i></span>
          </a>
          <a class="level-item">
            <span class="icon is-small"><i class="fa fa-heart"></i></span>
          </a>
        </div>
      </nav>-->
    </div>    
    <div class="media-right is-hidden-mobile">
    
      <router-link :to="'/material/game/' + item.id">
        <i class="fa fa-arrow-right" aria-hidden="true"></i>
      </router-link>

      <router-link v-if="user === item.user.id" :to="'/material/alter/' + item.id">
        <i class="fa fa-pencil has-tooltip" aria-hidden="true"></i>
      </router-link>
    
      <i v-if="user === item.user.id" @click="drop" class="fa fa-close text-danger pointer" aria-hidden="true"></i>

    </div>
  </article>
</template>

<script>
  export default {
    props: ['item', 'example'],    
    data () {
      return {
        user: window.User.id
      }
    },
    methods: {
      drop () {
        if (!confirm('Tem certeza que deseja excluir a atividade selecionada?'))
          return false
        let self = this
        self.$http.delete('/api/lesson/' + this.item.id)
          .then(data => self.$emit('drop', data.body.data.id))
          .catch(err => {console.log(err); self.$emit('error', { 'drop': err })})
      },
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
  .media-left img
    border-radius: 3px
    overflow: hidden
  .image.is-64x64
    overflow: hidden
    margin-top: 10px
    img
      margin-top: 0 !important
      max-width: none
      height: 100%
      width: auto
  p.image.example
    background-color: #ccc
    margin-top: 0
  strong.example
    margin-bottom: 0.3rem
    display: block
    height: 0.85rem
    width: var(--size, 50%)
    background-color: #ccc
</style>