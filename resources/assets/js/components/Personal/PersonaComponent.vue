<template>
  <section>
    <div class="tabs">
      <ul>
        <li v-for="(item, i) in menu"
          :key="i"
          :class="{'is-active' : i == atual}">
          <a @click="atual = i">{{ item }}</a>
        </li>
      </ul>
    </div>
    <!--<icon-persona-component></icon-persona-component>-->
    <div class="margin-left">
      <section id="sobre" v-show="atual == 0">
        <span class="text-medium">Nome:</span> {{ user.name }}<br>
        <span class="text-medium">Idade:</span> 21 anos<br>
        <span class="text-medium">Instituição:</span> UFSCar Sorocaba<br>
        <span class="text-medium">Usuário desde:</span> 01/02/2017<br>
        <h4 class="text-medium" style="margin-top: 20px;">Comentários</h4>
        <twit-component v-for="(item, i) in comments"
          :key="i"
          :comment="item"></twit-component>
        <empty-component v-show="!comments.length" :hide="true" :message="'Ninguém comentou suas atividades ainda :('"></empty-component>
      </section>
      <section id="conc" v-show="atual == 1">
        <div class="text-medium margin-bottom">Classes coordenadas por Felipe</div>
        <div class="columns"
          style="margin-bottom: 0"
          v-for="(j, index) in 2"
          :key="index">
          <article class="column is-2"
            v-for="(i, key) in 5"
            :key="key">
            <course-item-component :text="'1ª Ano A'"></course-item-component>
          </article>
        </div>
      </section>
      <section id="cursos" v-show="atual == 2">
        <div class="text-medium margin-bottom">Cursos concretizados por Felipe</div>
        <div class="columns"
          style="margin-bottom: 0"
          v-for="(j, index) in 2"
          :key="index">
          <article class="column is-2"
            v-for="(i, key) in 5"
            :key="key">
            <course-item-component :text="'O que são algoritmos'"></course-item-component>
          </article>
        </div>
      </section>
      <section id="conq" v-show="atual == 3">
        <div class="text-medium margin-bottom">Conquistas de Felipe</div>
        <div class="columns"
          style="margin-bottom: 0.75rem"
          v-for="(j, key) in 2"
          :key="key">
          <article class="column is-5 box"
            style="margin-bottom: 0.75rem; margin-left: 0.5rem"
            v-for="(i, index) in 2"
            :key="index">
            <div class="columns">
              <div class="column is-4">
                <course-item-component :hide="true"></course-item-component>
              </div>
              <div class="column is-8" style="padding: 20px">
                Primeira atividade concluída
              </div>
            </div>
          </article>
        </div>
      </section>
    </div>
  </section>
</template>
<script>
  import IconPersonaComponent from './IconPersonaComponent.vue'
  import EmptyComponent from '../EmptyComponent.vue'
  import CourseItemComponent from '../Courses/CourseItemComponent.vue'
  import TwitComponent from  './TwitComponent.vue'

  export default {
    mounted () {
      let self = this
      self.$http.get('/api/comment', { params: { user: window.User.id } })
        .then(data => (self.comments = data.body.data.comments))
    },
    components:{
      IconPersonaComponent,
      CourseItemComponent,
      TwitComponent,
      EmptyComponent
    },
    props: ['user'],
    data () {
      return {
        atual: 0,
        menu: ['Sobre', 'Classes', 'Cursos', 'Conquistas'],
        comments: []
      }
    }
  }
</script>