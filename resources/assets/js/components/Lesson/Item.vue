<template>
  <article class="media" id="item-component">
    <div class="is-hidden-tablet" v-if="!example">
      <router-link :to="'/material/game/' + item.id">
        <figure class="image">
          <img :src="item.photo ? '/upload/' + item.photo: '/images/placeholders/128x128.png'" alt="">
        </figure>
      </router-link>
      <div class="has-text-centered">
        {{ item.name }}
      </div>
    </div>
    <figure class="media-left is-hidden-mobile">
      <p class="image is-64x64 example" v-if="example"></p>
      <p class="image is-64x64" v-if="!example">
        <img :src="item.photo ? '/upload/' + item.photo: '/images/placeholders/128x128.png'">
      </p>
    </figure>
    <div class="media-content is-hidden-mobile">
      <div class="content">
        <p>
          <strong class="example" style="--size: 76%" v-if="example"></strong>
          <strong class="example" style="--size: 46%" v-if="example"></strong>
          <strong class="example" style="--size: 56%" v-if="example"></strong>
          <strong class="example" style="--size: 86%" v-if="example"></strong>
          
          <strong v-if="!example">{{ item.name }}</strong> <small v-if="!example && item.link">Disponível por <a :href="item.link">{{ item.source }}</a></small>
          <br>
          <span v-if="!example">
            Conceitos: <em><span v-for="c in item.concepts">{{ c.name }}; </span><span v-show="!item.concepts.length">Sem conceitos cadastrados</span><br></em>
            Tema/Assunto: <em>{{ item.topics.length ? item.topics[0].name : 'Sem tema/assunto cadastrado' }}<br></em>
            Idade/Ano: <em>{{ item.age ? '+' + item.age + ' anos' : 'Sem idade cadastrada'}}<br></em>
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
    <div class="media-right is-hidden-mobile" v-if="!example">
      <router-link :to="'/material/game/' + item.id">
        <i class="fa fa-arrow-right" aria-hidden="true"></i>
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
      }
    }
  }
</script>

<style lang="sass" scoped>
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