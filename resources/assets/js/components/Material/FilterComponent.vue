<template>
  <section style="flex: 1">
    <form class="box" action="#" method="get" @submit.prevent="search(form)">
      
      <div class="columns">
        <div class="column is-12">
          <h4>Filtros de pesquisa</h4>
          <span v-if="form.name.length > 0"><i>Título</i></span>
          <input class="input" v-model="form.name" type="text" placeholder="Pesquisar">
        </div>
      </div>

      <div class="columns">
        <div class="column is-12">
          <span v-if="form.pc_components.length > 0"><i>Elemento do PC</i></span>
          <span class="select is-fullwidth">              
            <select v-model="form.pc_components">
              <option value="">Tópicos de PC</option>
              <option :value="item.id" v-for="item in pc_component">{{ item.description }}</option>
            </select>
          </span>
        </div>
      </div>

      <div class="columns">
        <div class="column is-12">
          <span v-if="form.bncc_components.length > 0"><i>Elemento da BNCC</i></span>
          <span class="select is-fullwidth">            
            <select v-model="form.bncc_components">
              <option value="">Tópicos da BNCC</option>
              <option :value="item.id" v-for="item in bncc_component">{{ item.description }}</option>
            </select>
          </span>    
        </div>
      </div>
      
      <div class="columns">
        <div class="column is-12">
          <label>Faixa etária</label>
          <br>
          <br>
          <br>
          <vue-slider :min="2" :max="24" v-model="form.age"></vue-slider>    
        </div>
      </div>

      <div class="columns">        
        <div class="column is-12 flex-center">
          <label><input type="checkbox" v-model="form.ageCheck" name=""/> Ignorar faixa etária</label>
          <br>
          <button type="submit" class="button is-primary is-outlined">Pesquisar</button>
        </div>
      </div>

    </form>    
  </section>
</template>

<script>
  import Utils from '../../modules/utils'
  import vueSlider from 'vue-slider-component'

  export default {
    components: {      
      vueSlider
    },
    mounted () {
      let self = this
      self.$http.get('/api/bncc/json')
        .then(resp => (self.bncc_component = resp.body))
      self.$http.get('/api/pc/json')
        .then(resp => (self.pc_component = resp.body))
    },
    methods: {
      search (form) {
        let self = this
        self.$emit('load', null)
        Utils.submit(form, '/api/lesson', self.$http, 'get')
          .then(data => self.$emit('search', { data: data.body.data.lessons, pages: data.body.data.pages, form, page: 0 }))
      }
    },
    data () {
      return {
        bncc_component: [],
        pc_component: [],
        form: {
          pc_components:"",
          bncc_components:"",
          name: '',
          age: [2,24],
          ageCheck: true
        }
      }
    }
  }
</script>