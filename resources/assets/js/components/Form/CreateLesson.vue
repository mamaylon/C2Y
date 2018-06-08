<template>
  <section style="flex: 1">
    <!-- <article class="">
      <form-component :form="data" :name="'atividade'" :api="'/api/lesson'"></form-component>
    </article> -->
    <white-component></white-component>
    <section class="columns message" v-show="success">
      <div class="column is-8 is-offset-2 notification is-success">
        <button type="button" class="delete" @click="success = false"></button>
        Parabéns, você cadastrou um atividade :)
      </div>
    </section>
    <create :title="'Criar atividade'" :api="'/api/lesson'" :hide="true" :model="form" :callback="callback" @error="handle">
      
      <div class="columns">
        <a id="topo"></a>
        <a href="#topo" id="link"></a>
        <div class="column is-12">
          <div class="notification is-danger" v-show="err">            
            Tivemos alguns problemas para salvar a atividade :(
            <br/>
            <div class="content">
              <ul>
                <li v-for="(err, index) in err" :key="index">
                  <label>{{err[0]}}</label>
                </li>              
              </ul>  
            </div>
          </div>
        </div>
      </div>

      <div class="columns">
        <div class="column is-12">
          <p class="help is-danger flex-center">
            <span>Campos preenchidos com * são obrigatórios</span>
          </p>
        </div>
      </div>

      <div class="columns">
        
        <div class="column is-6">          
          <span v-if="form.name.length > 0"><i>Nome</i></span>
          <input type="text" name="name" v-model="form.name" class="input flat" placeholder="Nome da atividade*">   
        </div>
        
        <div class="column is-6">          
          <label>Escolha o modelo da atividade*</label>                    
          <div>
            <label><input type="radio" value="Desplugada" v-model="form.model"> Desplugada</label>
            <label><input type="radio" value="Plugada" v-model="form.model"> Plugada</label>
          </div>          
        </div>           

      </div>

      <div class="columns">        
        <div class="column is-12">
          <label>Faixa etaria recomendada (em anos)*</label>         
          <br>
          <br>
          <br>
          <div>
            <vue-slider :min="2" :max="24" v-model="form.age_range"></vue-slider>
          </div>
                    
        </div>

      </div>

      <div v-if="form.model == 'Plugada'" class="columns">
        <div class="column is-12">          
          <input type="text" name="link" v-model="form.link" class="input flat" placeholder="Link externo para atividade">
          <p class="help is-primary">
            <span>Este link é necessário quando a atividade possiu algum conteudo para ser realizado ONLINE, para material de consulta utilizar a área de <i>Referências</i> ao fim do documento</span>
          </p>
        </div>
      </div>

      <div class="columns">
        <div class="column is-12">
          
          <div>
            <label>Por favor nos diga quem criou a atividade*</label><br>
            <div>
              <label><input type="radio" value="true" v-model="form.owner">Eu mesmo criei! </label>

              <label><input type="radio" value="false" v-model="form.owner">Estou apenas inserindo ela no sistema</label>
            </div>
          </div>

          <div v-show="form.owner == 'false'">
            <br>
            <label>Então por favor indique o(s) criador(es)*</label>
            <br>
            <multiselect 
                v-model="teste" 
                :options="ownersALL"                
                :hide-selected="true"
                label="name"
                track-by="id"
                placeholder = "Pesquise aqui pelo nome do autor"
                selectLabel = "Enter para selecionar"
                @select="onChange"
                @close="clean"
                >
                  <template slot="noResult"><p>Nome não econtrado no cadastro</p></template>
                </multiselect>

            <table class="table is-fullwidth is-striped">
              <thead>
                <tr>                  
                  <td style="display:none">id</td>
                  <td>Nome</td>                                    
                  <td>E-mail</td>
                  <td>Opções</td>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(row, index) in form.owners">                  
                  <td style="display:none" v-model="row.id"></td>
                  <td><input class="input flat" type="text" v-model="row.name"></td>
                  <td><input class="input flat" type="text" v-model="row.email"></td>
                  <td>
                    <a v-on:click="removeElement(index,1);" class="delete is-medium"></a>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3">
                    <a class="btn btn-primary" @click="addRow(1)" ><span class="fa fa-plus"></span>
                    Não encontrou na lista? Clique aqui para adicionar um autor manualmente!</a>
                  </td>
                </tr>    
              </tfoot>
            </table>

          </div>

        </div>
      </div>


      <div class="columns">
        <div class="column is-12">
          <div>
            <span v-if="form.bncc_component.length > 0"><i>Elementos BNCC</i></span>
            <multiselect 
                v-model="form.bncc_component" 
                :options="bncc_components"
                :multiple="true"
                :close-on-select="false"
                :hide-selected="true"
                label="description"
                track-by="id"
                placeholder = "Escolha elementos da BNCC"
                selectLabel = "Enter para selecionar"
                selectedLabel = "Selecionado"                
                >
                <template slot="noResult"><p>Nenhum elemento encontrado</p></template>
              </multiselect>
          </div>
        </div>        
      </div>


      <div class="columns">
        <div class="column is-12">
          <div>
              <span v-if="form.pc_component.length > 0"><i>Elementos PC</i></span>
              <multiselect 
                v-model="form.pc_component" 
                :options="pc_components"
                :multiple="true"
                :close-on-select="false"
                :hide-selected="true"
                label="description"
                track-by="id"
                placeholder = "Escolha topicos do Pensamento Computacional"
                selectLabel = "Enter para selecionar"
                selectedLabel = "Selecionado"                
                >
                  <template slot="noResult"><p>Nenhum elemento encontrado</p></template>
                </multiselect>
          </div>
        </div>
      </div>


      
      <div class="columns">
        <div class="column is-6">
          <span v-if="form.description.length > 0"><i>Descrição</i></span>
          <textarea class="input" placeholder="Descrição da atividade*" v-model="form.description"></textarea>
        </div>        

        <div class="column is-6">
          <span v-if="form.goals.length > 0"><i>Objetivos</i></span>
          <textarea class="input" placeholder="Objetivos da atividade*" v-model="form.goals"></textarea>
        </div>        
      </div>

      <div class="columns">

        <div class="column is-6">
          <span v-if="form.resources.length > 0"><i>Recursos</i></span>
          <textarea class="input" placeholder="Recursos para realização da atividade" v-model="form.resources"></textarea>
        </div>

        <div class="column is-6">
          <span v-if="form.suggestions.length > 0"><i>Sugestões</i></span>
          <textarea class="input" placeholder="Sugestões de alteração para a atividade" v-model="form.suggestions"></textarea>
        </div>

      </div>

      <div class="columns">
        <div class="column is-12">      
            <div class="upload">
              <label>Área para upload de imagens</label>
              <p class="help is-primary">
                <span>As imagens ficarão disponiveis em um <i>SlideShow</i> para visualização do usuario</span>
              </p>
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Miniatura</th>
                    <th>Nome</th>
                    <th>Tamanho</th>
                    <th>Opções</th>  
                  </tr>                    
                </thead>

                <tbody>
                  <tr v-for="(file, index) in form.images" :key="file.id">
                    <td>{{index+1}}</td>
                    <td>
                      <a target="_blank" v-if="file.thumb" :href="file.thumb"><img :src="file.thumb" width="60" height="auto" /></a>
                      <span v-else>Sem Imagem</span>
                    </td>
                    <td>{{file.name}}</td>
                    <td v-if="(file.size/(1024)) < 1000">{{(file.size/(1024)).toFixed(2)}} kB</td>
                    <td v-else>{{(file.size/(1024*1024)).toFixed(2)}} MB</td>
                    <td><a class="delete is-medium" @click.prevent="$refs.uploadImage.remove(file)"></a></td>                      
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5">
                        <div class="example-btn">                  
                          <file-upload
                            class="btn btn-primary"
                            post-action="/upload/post"
                            extensions="gif,jpg,jpeg,png,webp"
                            accept="image/png,image/gif,image/jpeg,image/webp"
                            :multiple="true"
                            :size="1024 * 1024 * 10"
                            v-model="form.images"
                            @input-filter="inputFilter"
                            @input-file="inputFile"
                            ref="uploadImage">
                            <i class="fa fa-plus"></i>
                            Clique aqui para adicionar imagens
                          </file-upload>
                        </div>
                    </th>
                  </tr>                      
                </tfoot>
              </table>
            </div>                
        </div>
      </div>

      <div class="columns">
          <div class="column is-12">
            <label>Área para upload de documentos</label>
            <p class="help is-primary">
              <span>Os documentos aqui inseridos ficarão disponiveis para download pelo usuario</span>
            </p>
            <div>
              <table class="table is-fullwidth is-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Tamanho</th>
                    <th>Opções</th>  
                  </tr>                    
                </thead>

                <tbody>
                  <tr v-for="(file, index) in form.files" :key="file.id">
                    <td>{{index+1}}</td>
                    <td>{{file.name}}</td>
                    <td v-if="(file.size/(1024)) < 1000">{{(file.size/(1024)).toFixed(2)}} kB</td>
                    <td v-else>{{(file.size/(1024*1024)).toFixed(2)}} MB</td>
                    <td><a class="delete is-medium" @click.prevent="$refs.uploadFile.remove(file)"></a></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="4">
                      <div class="example-btn">                  
                        <file-upload
                          class="btn btn-primary"
                          post-action="/upload/post"
                          extensions="pdf,doc,docx,gif,jpg,jpeg,png,webp"
                          
                          :multiple="true"
                          :size="1024 * 1024 * 10"
                          v-model="form.files"
                          @input-filter="inputFilter"
                          @input-file="inputFile"
                          ref="uploadFile">
                          <i class="fa fa-plus"></i>
                          Clique aqui para adicionar arquivos
                        </file-upload>
                      </div>
                    </th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
      </div>

      <div class="columns no-margin-bottom">
        <div class="column is-12 no-padd-bottom">
          <div>
            <label>Área para cadastro de referências</label>
            <p class="help is-primary">
              <span>As referências serão apresentadas para usuario em forma de lista e ele poderá acessar o endereço com apenas um clique</span>
            </p>
            <table class="table is-fullwidth is-striped">
              <thead>
                <tr>                  
                  <td>Descrição</td>                  
                  <td>Link</td>
                  <td>Opções</td>
                </tr>
              </thead>

              <tbody>
                <tr v-for="(row, index) in form.refs">
                  <td><input class="input flat" type="text" v-model="row.description"></td>
                  <td><input class="input flat" type="text" v-model="row.link"></td>
                  <td>
                    <a v-on:click="removeElement(index,2);" class="delete is-medium"></a>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3">
                    <a class="btn btn-primary" @click="addRow(2)" ><span class="fa fa-plus"></span>
                    Clique para adicionar uma referência</a>
                  </td>
                </tr>    
              </tfoot>
            </table>

          </div>          
        </div>
      </div>

    </create>
  </section>
</template>

<script>
  import Create from '../Courses/CreatePrototype.vue'
  import WhiteComponent from '../WhiteComponent.vue'
  import Multiselect from 'vue-multiselect'
  import FileUpload from 'vue-upload-component'
  import vueSlider from 'vue-slider-component'
    
  export default {
    components: {
      Create,
      WhiteComponent,
      Multiselect,
      FileUpload,
      vueSlider
    },
    mounted () {      
      let self = this

      self.$http.get('/api/bncc/json')
        .then(resp => (self.bncc_components = resp.body))
      self.$http.get('/api/pc/json')
        .then(resp => (self.pc_components = resp.body))
      self.$http.get('/api/owner/json')
        .then(resp => (self.ownersALL = resp.body))
    },
    methods: {
      handle (err) {
        this.err = err
        document.getElementById('link').click();
      },
      callback (data) {
        this.err = false        
        this.$modal({
          data: {
            text: 'Parabéns, você cadastrou uma atividade :)',
            subtext: 'A comunidade C2Y! agradece.',
            success: true
          },
          timeout: 3000,
          onClose: true
        })

        for(let i in this.form)
        {
          Array.isArray(this.form[i]) ? this.form[i] = [] : this.form[i] = ""
          if(i == "age_range")
            this.form[i] = [2,3];
        }

        document.getElementById('link').click();
      },
      inputFilter(newFile, oldFile, prevent) {
        if (newFile && !oldFile) {
          // Before adding a file
          // Filter system files or hide files
          if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
            return prevent()
          }
          // Filter php html js file
          if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
            return prevent()
          }
        }

        if (newFile && (!oldFile || newFile.file !== oldFile.file)) 
        {
          //create a string64 based on blob
          var reader = new FileReader();
          reader.readAsDataURL(newFile.file);          
          reader.onloadend = function()
          {
              var base64data = reader.result;              
              newFile.strBlob = base64data.substr(base64data.indexOf(',')+1);              
          }
          //create a thumb when is a image
          let URL = window.URL || window.webkitURL
          newFile.thumb = ''
          if (newFile.file && newFile.type.substr(0, 6) === 'image/') {
            newFile.thumb = URL.createObjectURL(newFile.file)
          }
        }

      },
      inputFile(newFile, oldFile) {
        if (newFile && !oldFile){ //when add 
        }
        if (newFile && oldFile) {// update
        }
        if (!newFile && oldFile) {// remove target is oldFile          
        }
      },
      addRow: function(child) {
          var elem = document.createElement('tr');
          
          if(child == 1)
          {
            this.form.owners.push({
                id:"-1",
                name: "",
                email: ""
            });
          }
          if(child == 2)
          {
            this.form.refs.push({
                link: "",
                description: ""
            });
          }          
      },
      removeElement: function(index,child) {
          if(child == 1)
            this.form.owners.splice(index, 1);
          if(child == 2)
            this.form.refs.splice(index, 1);
      },
      onChange(atual)
      {
        if(atual != null && atual != "")
        {
          this.form.owners.push(atual);
        }
      },
      clean(){
        this.teste = "";
      }
    },
    data () {
      return {
        form: {
          name: '',
          link: '',          
          description: '',          
          bncc_component: [],
          pc_component: [],
          model: '',
          suggestions: '',
          resources:'',
          goals:'',
          age_range:[2,3],
          files: [],
          images: [],
          refs:[],
          owner: null,
          owners : []
        },
        err: false,
        bncc_components: [],
        pc_components: [],        
        success: false,
        ownersALL: [],
        teste:""
      }
    }
  }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="sass" scoped>
  .columns.message
    margin: 1rem 0 0 0
  .is-multiple select
    height: 10rem
    font-size: 0.8rem
  .option-title
    font-weight: 700
    color: var(--color)

</style>