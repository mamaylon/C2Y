<template>
  <section>
    <article class="body">
      <h4 class="text-medium subtitle">Escolher usuário</h4>
      <div>Para adicionar um usuário moderador, é primeiro necessário que ele esteja entre os usuários presentes na sala</div>
      <article class="grid">
        <figure
          v-for="user in users"
          :key="user.id"
          @click="set(user)"
          v-tooltip.top="user.name"
          class="pointer image is-48x48">
          <img :src="toSize(user.photo, 48)" alt="">
          <div class="active" v-if="activeUser === user">
            <i class="fa fa-fw fa-check-circle"></i>
          </div>
        </figure>
      </article>
      <h4 class="text-medium subtitle">Escolha uma função</h4>
      <span v-for="(item, index) in types"
        :key="index"
        class="tag no-select"
        :class="{ 'is-primary': active === index }"
        @click="active = index">
        {{ item.name }}
      </span>
    </article>
    <footer class="modal-footer">
      <button
        @click="$modal('close')"
        class="button is-outlined">Cancelar</button>
      <button
        :disabled="!activeUser"
        @click="sync()"
        :class="{'is-outlined': !wait}"
        class="button is-primary ">
          <i class="fa fa-fw fa-circle-o-notch fa-spin" v-if="wait"></i> Confirmar
        </button>
    </footer>
  </section>
</template>

<script>
  import mixin from '../../../mixins/index'
  import { EventBus } from '../../../modules/bus'
  const keys = {
    assistant: 0,
    monitor: 1,
    student: 2
  }

  export default {
    name: 'Assign',
    mixins: [mixin],
    props: {
      data: Object
    },
    data: _ => ({
      active: -1,
      activeUser: null,
      wait: false,
      types: [
        {role: 'assistant', name: 'Auxiliar'},
        {role: 'monitor', name: 'Monitor'},
        {role: 'student', name: 'Aluno'}
      ],
    }),
    methods: {
      set (user) {
        this.activeUser = user
        this.active = keys[user.role]
      },
      sync () {
        this.wait = true
        let params = {
          code: this.$store.getters.classroom.code,
          user: this.activeUser.id,
          role: this.types[this.active].role
        }
        this.$http.post('/api/classroom/sync', params)
          .then(resp => {
            if (resp.body.error) {
              throw new Error(resp.body.error)
            }
            EventBus.$emit('user:assign', { user: this.activeUser.id, role: this.types[this.active].role })
            this.$modal('close')
          })
          .catch(err => {
            this.$toastr.e('Erro ao adicionar moderador')
          })
          .then(_ => (this.wait = false))
      }
    },
    computed: {
      users () {
        let index = this.data.masters.map(it => it.index)
        return this.data.users
          .filter(user => user.id !== this.$store.getters.user.id && index.indexOf(user.id) < 0)
      }
    }
  }
</script>

<style lang="sass" scoped>
  .grid
    display: grid
    grid-template-columns: repeat(10, 1fr)
    grid-gap: .3rem
    margin: 1rem auto
  figure
    overflow: hidden
    border-radius: 3px
    position: relative
    .active
      position: absolute
      top: 0
      left: 0
      background: rgba(0, 0, 0, 0.7)
      height: 100%
      width: 100%
      display: flex
      align-items: center
      justify-content: center
      i
        color: white
        font-size: 1.5rem
  .tag
    border-radius: 3px
  .modal-footer
    padding: 1rem
    border-top: thin solid var(--border)
    justify-content: flex-end
    display: flex
    button
      margin-left: .3rem
  .body
    padding: 2rem
    padding-bottom: 1rem
    .subtitle
      margin-bottom: .2rem
</style>
