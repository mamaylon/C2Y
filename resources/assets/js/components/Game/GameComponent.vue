<template>
  <section class="container margin-bottom">    
    <section class="columns">
      <article class="column is-12 is-offset-one-fifth">
        <div class="box" style="overflow: hidden" v-if="lesson">
          
          <div class="columns">
            <div class="column is-5">
              <div class="flex-center">
                <i class="icon-c2y is-dark fa-5x"></i>
              </div>              
            </div>
            <div class="column is-4">
              <div class="content">
                <span>Titulo:</span> 
                <strong class="strong">{{ lesson.name }}</strong><br>
                <span v-if="lesson.link">Atividade fornecida por: 
                  <a :href="lesson.link">{{ lesson.source }}<br/></a>
                </span>
                <span>Faixa Etaria Sugerida:</span> 
                <strong class="strong">{{lesson.age_min+" a "+lesson.age_max+" anos"}}</strong><br>
                <span>Tipo:</span> 
                <a href="#">{{ lesson.model }}</a><br>
                <span>Cadastrado por:</span> 
                <a href="#">{{ lesson.user.name }}</a><br>
                <span>Data do cadastro:</span> 
                <a href="#">{{ lesson.created_at.substr(8,2)+"/"+lesson.created_at.substr(5,2)+"/"+lesson.created_at.substr(0,4) }}</a>                
              </div>
            </div>
            <div class="column is-3">
              <table class="is-fullwidth">
                <thead>
                  <tr>
                    <th v-if="lesson.owner || lesson.owners.length == 1">
                      Proposto por: 
                    </th>
                    <th v-else>
                      Proposto por:
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <div v-for="owner in lesson.owners">
                    <tr>
                      <td><label>{{owner.name}}</label></td>
                    </tr>
                    <tr>
                      <td><i>{{owner.email}}</i></td>
                    </tr>  
                  </div>
                  <div v-if="lesson.owner">
                    <tr>
                      <td><label>{{lesson.user.name}}</label></td>
                    </tr>
                    <tr>
                      <td><i>{{lesson.user.email}}</i></td>
                    </tr>
                  </div>
                </tbody>
              </table>
            </div>
          </div>

          <div class="columns">            
            <div class="column is-12">
              <div id="panel" class="flex-center"  v-if="lesson.source != 'Scratch'">  
                <slider :sources="lesson.lesson_images"></slider>                
              </div>              
              <iframe v-if="lesson.source == 'Scratch'" allowtransparency="true" :src="'//scratch.mit.edu/projects/embed/' + lesson.link_id + '/?autostart=false'" frameborder="0" allowfullscreen>                
              </iframe>
            </div>
          </div>

          <div class="columns">
            
          </div>

          <div class="columns">
            <div class="column is-6">
              <label class="tag is-primary">Componentes da BNCC</label>
              <div class="content">
                <ul>
                  <li v-for="(value,index) in lesson.bncc_components">
                    <label>{{value.name}}</label>
                  </li>
                  <li v-if="lesson.bncc_components.length == 0"><label>Nenhum componente foi inserido</label></li>
                </ul>
              </div>
            </div>
            <div class="column is-6">
              <label class="tag is-primary">Componentes do Pensamento Computacional</label>
              <div class="content">
                <ul>
                  <li v-for="(value,index) in lesson.pc_components">
                    <label>{{value.name}}</label>
                  </li>
                  <li v-if="lesson.pc_components.length == 0"><label>Nenhum componente foi inserido</label></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="columns">
            <div class="column is-6">
              <span class="tag is-info">Descrição</span><br>
                <div class="content">
                  <ul>
                    <li>
                      <label>{{ lesson.description }}</label>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="column is-6">
              <span class="tag is-info">Objetivos</span><br>
                <div class="content">
                  <ul>
                    <li>
                      <label>{{ lesson.goals}}</label>
                    </li>
                  </ul>                  
                </div>
            </div>            
          </div>

          <div class="columns">
            <div class="column is-6">
              <span class="tag is-success">Recursos</span><br>
              <div class="content">
                <ul>
                  <li>
                    <label>{{ lesson.resources || 'Nenhum recurso foi informado' }}</label>
                  </li>
                </ul>                  
              </div>
            </div>
            <div class="column is-6">
              <span class="tag is-success">Sugestões de alteração</span><br>
                <div class="content">
                  <ul>
                    <li>
                      <label>{{lesson.suggestions || 'Nenhuma sugestão foi cadastrada'}}</label>
                    </li>
                  </ul>                  
                </div>
            </div>
          </div>
          
          <div class="columns">
            <div class="column is-12">
              <article class="message is-link">
                <div class="message-body">
                  <label>Referências utilizadas nesta atividade</label>
                  <table class="table is-fullwidth is-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Descrição</th>
                        <th>Link</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row,index) in lesson.lesson_references">
                        <td>{{index+1}}</td>
                        <td>{{row.description}}</td>
                        <td><a target="_blank" :href="row.link.startsWith('http://')?row.link:'http://'+row.link">{{row.link}}</a></td>
                      </tr>
                      <tr v-if="lesson.lesson_references.length == 0">
                        <td colspan="3"><i>Esta atividade não contém nenhuma referência</i></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </article>
            </div>
          </div>

          <div class="columns">
            <div class="column is-12">
              <article class="message is-link">
                <div class="message-body">
                  <label>Arquivos disponibilizados pelo autor</label>
                  <table class="table is-fullwidth is-striped">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Opções</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(row,index) in lesson.lesson_files">
                        <td>{{index+1}}</td>
                        <td>{{row.name}}</td>
                        <td><a :href="makeUrlBlob(row.file,row.type)" :download="row.name"><i class="fa fa-download"></i></a></td>
                      </tr>
                      <tr v-if="lesson.lesson_files.length == 0">
                        <td colspan="3"><i>Esta atividade não contém nenhum anexo</i></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </article>
            </div>
          </div>

          <div v-if="lesson.link" class="columns">
            <div class="column is-12">
              <div class="notification flex-center">
                <div>                  
                  <p>
                    Para completar essa atividade, é necessário que você acesse um link externo, você pode acessa-lo clicando no botão abaixo.                  
                  </p>
                  <br>
                </div>

                <div>
                  <a :href="lesson.link" target="_blank" class="button is-outlined is-primary">Visitar atividade</a>
                </div>

                <div>
                  <br>
                  <p>                    
                    Após completar a atividade, você pode concluí-la clicando no botão "Concluir esta atividade" :)                
                  </p>
                  <br>
                </div>

                <a @click="complete" :disabled="lesson.completeds.length > 0" class="button is-success is-outlined">
                        {{ lesson.completeds.length ? 'Atividade concluída' : 'Concluir esta atividade' }}
                      </a>
              </div>
            </div>
          </div>

          <div class="columns">
            <div class="column is-12">
              <div>
                  <div class="notification" v-show="notify">
                    <button class="delete" @click="notify = false"></button>
                    Seu comentário foi enviado à {{ lesson.user.name }} :D
                  </div>
                  
                  <div v-show="!notify" class="content">
                    <article class="message is-primary">
                      <div class="message-header">
                        <p>Você pode enviar um comentario a quem cadastrou essa atividade ;)</p>
                      </div>
                      <div class="message-body">
                        <div>
                          <span v-if="body.length > 0" class="help"><i>Mensagem a ser enviada</i></span>
                          <textarea v-model="body" class="input" placeholder="Digite seu comentário aqui"></textarea><br>
                        </div>    
                        <div class="flex-center">
                          <br>
                          <button class="button is-primary is-outlined" @click="comment">Enviar</button>                    
                        </div>
                      </div>
                    </article>
                  </div>
                </div>
            </div>
          </div>

          <div class="columns">
            <div class="column is-12">
              <div class="flex-center">
                <router-link v-if="course" :to="'/courses/graph/' + course" class="button is-primary is-outlined">Voltar ao curso</router-link>
              </div>
            </div>
          </div>
        </div>
      </article>
    </section>
  </section>
</template>

<script>

  import Slider from '../slide.vue'

  let format = item => {
    if (item.source == 'Scratch')
      item.link_id = item.link.replace('https://scratch.mit.edu/projects/', '').split('/')[0]
    return item
  }

  export default {
    components:{
      Slider
    },    
    mounted()
    {
      this.course = this.$route.params.course      
      this.$http.get('/api/lesson/' + this.$route.params.id, { params: { user: this.user.id } }).then(data => (this.lesson = format(data.body.data.lesson)))
    },
    methods: {
      complete () {
        if (this.lesson.completeds.length) {
          return false
        }
        this.$http.post('/api/lesson/complete/' + this.lesson.id, { user: this.user.id })
          .then(data => this.lesson.completeds.push(true))
          .catch(err => console.log(err))
      },
      comment () {
        let data = {
          type: 'lesson',
          id: this.lesson.id,
          body: this.body,
          user: this.user.id,
          receiver: this.lesson.user.id
        }
        this.$http.post('/api/comment', data)
          .then(data => (this.notify = true, this.body = ''))
          .catch(err => console.log(err))
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
    },
    data () {
      return {
        notify: false,
        lesson: null,
        course: null,
        body: '',
        images:[]
      }
    },
    computed: {
      user () {
        return this.$store.getters.user
      }
    }
  }
</script>

<style scoped lang="sass">
  @import "../../../sass/variables" 
  .notification
    background-color: rgba($primary, 0.1)
  #panel
    & > div
      padding: 1.2rem
      padding-bottom: 0
    i:before
      color: $dark
  iframe, #panel
    float: left
    margin: -10px 0 0 -10px
    width: 100%
    height: 65%
  span
    margin: 0 !important
  span:not(:first-of-type)
    display: inline-block
    /* margin: 10px !important */
    /*background-color: tomato;*/
</style>