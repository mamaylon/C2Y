<template>
  <section>
    <div style="background-color:white; height: 100%; width: 100%; position: absolute; top: 0; left: 0; z-index: 0"></div>
    <section class="container" id="teach-component">
      <!--INICIO: MODAL-->
      <modal-component :active="modal" :fn="close">
        <div class="container">
          <div class="column is-10 is-offset-1">
            <section class="box" style="padding: 30px">
              <div style="margin-bottom: 20px">
                <strong>Seleção de novas atividades</strong><br>
                Aute  artisan minim commodo, paleo incididunt chillwave anim.  Affogato kale chips air plant VHS fingerstache fanny pack.  Taxidermy gochujang letterpress, tbh occupy succulents vinyl laborum dolor  proident ex labore.
              </div>
              <div style="width: 70%; margin-bottom: 20px;">
                <input type="text" class="input flat" placeholder="Buscar por atividades">
              </div>
              <div class="columns" v-for="j in 2">
                <article class="column is-2" :class="{ 'is-active' : course == i + (j * 6) }" @click="course = i + (j * 6)" v-for="i in 6">
                  <course-item-component :hide="true"></course-item-component>
                </article>
              </div>
            </section>
          </div>
        </div>
      </modal-component>
      <!--FIM: MODAL-->
      <article class="content" style="position: relative; margin-top: -20px; min-height: 440px; padding-top: 20px; padding-bottom: 20px">
        <section class="columns">
          <article class="is-10 is-offset-1 column">
            <div>Top classes</div>
            <!--(figure[style="display: inline-block"].image.is-96x96>img[src="http://bulma.io/images/placeholders/128x128.png"])*10-->
            <figure v-for="i in 8" style="display: inline-block; margin-left: 10px" class="image is-96x96">
              <img src="http://bulma.io/images/placeholders/128x128.png" alt="">
            </figure>
          </article>
        </section>
        <section class="columns">
          <article class="column is-10 is-offset-1">
            <div>Elit nostrud butcher, keytar trust fund pop-up ennui af kickstarter post-ironic deep v hot chicken ugh.  Leggings adaptogen bitters sapiente tousled umami.  In  chicharrones irure, butcher pour-over thundercats helvetica coloring book fanny pack minim kinfolk nisi voluptate.  Veniam irony put a bird on it, church-key photo booth DIY.</div>
            <div style="margin-top: 30px; font-weight: bold">Passo {{ atual }}: {{ passos[atual - 1] }}</div>
            <section id="passo1" v-show="atual == 1">
              <div style="margin-top: 10px; width: 60%">
                <input class="input flat" placeholder="Dê um nome para a sua clase" type="text">
              </div>
              <div style="margin-top: 30px; width: 60%">
                <input class="input flat" placeholder="A qual escola pertence esta classe?" type="text">
              </div>
            </section>
            <section id="passo2" v-show="atual == 2" style="margin-top: 10px">
              <div style="width: 70%; margin-bottom: 20px;">
                <input type="text" class="input flat" placeholder="Buscar por cursos">
              </div>
              <div class="columns" v-for="j in 2">
                <article class="column is-2" :class="{ 'is-active' : course == i + (j * 6) }" @click="course = i + (j * 6)" v-for="i in 6">
                  <course-item-component :hide="true"></course-item-component>
                </article>
              </div>
            </section>
            <section id="passo3" v-show="atual == 3" style="margin-top: 10px">
              <div>
                <strong>Descrição do curso:</strong> Franzen ex kinfolk eu  tousled, trust fund humblebrag 3 wolf moon quis bushwick man bun pinterest hella ut keffiyeh.  Live-edge quinoa cred nihil, occupy do hoodie godard hell of.
              </div>
              <div v-for="(f, i) in [4, 2, 4, 3]">
                <div style="margin-top: 5px">Fase {{i+1}}</div>
                <article class="columns" style="margin-bottom: 5px">
                  <div class="column is-2 relative" v-for="i in f">
                    <course-item-component :hide="true"></course-item-component>
                    <i class="fa fa-times-circle-o close pointer" v-on:click="remove" aria-hidden="true"></i>
                  </div>
                  <div class="column is-2">
                    <div class="card create">
                      <article class="card-image">
                        <figure class="is-square ghost" @click="modal = true">
                          <i class="fa fa-plus add" aria-hidden="true"></i>
                          <img src="/images/placeholders/256x256.png" style="opacity: 0" alt="Image">
                        </figure>
                      </article>
                    </div>
                  </div>
                </article>
              </div>
            </section>
            <section id="passo4" v-show="atual == 4">
              <div style="margin-bottom: 30px">
                Forage excepteur  celiac nesciunt, whatever waistcoat esse  flexitarian chartreuse vape est  irony.  Drinking vinegar microdosing mumblecore ut in.  Single-origin coffee hot chicken pok pok, adaptogen bespoke lumbersexual ea officia  bushwick readymade neutra iPhone hexagon quinoa.  Vero four dollar toast asymmetrical, paleo poutine succulents af copper mug kale chips blue bottle.
              </div>
              <article class="columns">
                <div class="column ghost is-4 is-offset-2">
                  <figure class="image">
                    <img class="gopher" src="/images/logos/boia.svg">
                  </figure>
                  <div class="has-text-centered primary">Criar nova atividade a partir de um link externo</div>
                </div>
                <div class="column ghost is-4">
                  <figure class="image">
                    <img class="gopher" src="/images/logos/teach.svg">
                  </figure>
                  <div class="has-text-centered primary">Criar uma nova atividade no sistema</div>
                </div>
              </article>
            </section>
            <div style="margin-top: 20px">
              <button class="button is-outlined" :disabled="atual > 1 ? false : true" @click="atual -= 1">Anterior</button>
              <button class="button is-primary is-outlined" v-show="atual < 4" @click="atual += 1">Próximo</button>
              <router-link class="button is-primary is-outlined" to="/courses" v-show="atual == 4">Concluir</router-link>
            </div>
          </article>
        </section>
      </article>
    </section>
  </section>
</template>
<script>
  import CourseItemComponent from './Course/CourseItemComponent.vue'
  import ModalComponent from './ModalComponent.vue'
  export default {
    components: {
      CourseItemComponent,
      ModalComponent
    },
    methods: {
      remove (event) {
        var tar = event.target
        tar.parentNode.querySelector('img').classList.toggle('opacity')
      },
      close () {
        this.modal = false
      }
    },
    data () {
      return {
        atual: 1,
        course: 0,
        modal: false,
        passos: ['Crie sua classe', 'Escolher curso', 'Moldar curso', 'Adicionar atividades']
      }
    }
  }
</script>