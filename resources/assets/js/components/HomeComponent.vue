<template>
  <section class="container">
    <section class="columns">
      <div class="column is-10 is-offset-1">
        <div class="content">
            <div class="container-fluid">
                <div class="columns">
                    <div class="column is-4">
                        <div class="card no-margin">
                            <div class="header">
                                <h4 class="title">Participação nos cursos</h4>
                                <p class="category">Último mês</p>
                            </div>
                            <div class="content">
                                <div id="chartPreferences" class="ct-chart ct-perfect-fourth"></div>
                                <div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-clock-o"></i> Última atividade a 2 dias atrás
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="column is-8">
                        <div class="card no-margin">
                            <div class="header">
                                <h4 class="title">Notificações</h4>
                                <p class="category">Última semana</p>
                            </div>
                            <div class="content has-text-centered">
                              <div class="notify">
                                <i class="fa fa-envelope-o fa-fw" aria-hidden="true"></i><br>
                                Não há notificações
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="columns">
                  <div class="column is-6">
                    <div class="card">
                      <div class="header">
                        <h4 class="title has-text-centered">Usuários com mais lições feitas</h4>
                      </div>
                      <div class="content">
                        <div id="chartActivity" class="ct-chart"></div>
                      </div>
                    </div>
                  </div>

                  <div class="column is-6">
                    <div class="card ">
                        <div class="header">
                            <h4 class="title has-text-centered">Cursos mais acessados</h4>
                        </div>
                        <div class="content">
                          <div class="table-full-width">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                  </td>
                                  <td>Introdução ao pensamento computacional <br><small>Profª. Ana Maria Braga</small></td>
                                  <td><i class="fa fa-picture-o fa-fw fa-2x" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                  </td>
                                  <td>Você não sabe nem eu <br><small>Profº. Irineu</small></td>
                                  <td><i class="fa fa-picture-o fa-fw fa-2x" aria-hidden="true"></i></td>
                                </tr>
                                <tr>
                                  <td>
                                    <label class="checkbox">
                                        <input type="checkbox" value="" data-toggle="checkbox">
                                    </label>
                                  </td>
                                  <td>Tá pegando fogo bixo <br><small>Profª. Faustão</small></td>
                                  <td><i class="fa fa-picture-o fa-fw fa-2x" aria-hidden="true"></i></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          <div class="footer">
                              <hr>
                              <div class="stats">
                                  <i class="fa fa-history"></i> Updated 3 minutes ago
                              </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>
        </div>
        <!--<article class="content">
          <h1>Proposta do site</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla accumsan, metus ultrices eleifend gravida, nulla nunc varius lectus, nec rutrum justo nibh eu lectus. Ut vulputate semper dui. Fusce erat odio, sollicitudin vel erat vel, interdum mattis neque.</p>
        </article>
        <slider-component></slider-component>-->
      </div>
    </section>
  </section>
</template>

<script>
  import SliderComponent from './SliderComponent.vue'
  export default {
    components: {
      SliderComponent
    },
    mounted () {
      demo.initChartist();
    }
  }
</script>

<style lang="sass" scoped>
  .notify
    padding: 12vh 0 20vh
    color: #777
    i
      font-size: 5em
</style>