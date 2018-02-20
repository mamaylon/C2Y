<template>
	<section class="body">
		<form @submit.prevent="submit">
			<div class="field has-text-centered">
			  <h4 class="title text-medium">Participar de uma turma</h4>
			  <div class="text">Peça para seu professor o código da turma e digite-o aqui.</div>
			  <div class="control">
			    <input class="input"
	          :class="{'is-danger': error }"
			    	v-model="code"
			    	type="text"
			    	size="6"
			    	placeholder="Código da turma">
          <span v-show="error" class="help is-danger">
          	Esse código não é válido. Verifique se você digitou o código correto.
          </span>
			  </div>
		  	<button class="button is-fullwidth is-primary"
		  		:disabled="code.length < 6 || wait"
		  		:class="{ 'is-outlined': !wait }">
          <i class="fa fa-circle-o-notch fa-fw fa-spin" v-show="wait"></i>
		  		{{ wait ? 'Aguarde' : 'Participar' }}
		  	</button>
			</div>
		</form>

		<div class="has-text-centered option">
			<span class="or">
				OU
			</span>
		</div>

    <section class="has-text-centered">
      <h4 class="title text-medium">Crie sua classe</h4>
      <div>Elit nostrud butcher, keytar trust fund pop-up ennui af kickstarter post-ironic deep v hot chicken ugh.  Leggings adaptogen bitters sapiente tousled umami.</div>
      <button class="button is-primary is-outlined is-fullwidth" @click="origin.form()">
      	Criar minha turma
      </button>
    </section>

	</section>
</template>

<script>
	export default {
		name: 'AddClassroom',
		props: ['origin'],
		methods: {
			submit () {
        let message = {
          text: 'Você entrou na classe %s',
          subtext: 'Bons estudos',
          success: true
        }
				this.wait = true
				this.origin.sync(this.code)
					.then(data => {
						data = data.body
						if (data.error) {
							throw new Error(data.error.message)
						}
						let classroom = data.data.classroom
						this.$store.dispatch('push_classroom', classroom)
						message.text = message.text.replace('%s', classroom.name)
						this.$modal({ data: message, onClose: true, timeout: 3000 })
					})
					.catch(err => {
						this.error = true
						this.wait = false
					})
			}
		},
		data: _ => ({
			code: '',
			wait: false,
			error: false
		})
	}
</script>

<style lang="sass" scoped>
	.fa-spin
		margin-right: 0.4rem
	.option
		margin: 2rem auto
	.or
		display: inline-block
		border-radius: 50%
		--s: 3.5rem
		color: white
		height: var(--s)
		line-height: var(--s)
		width: var(--s)
		background-color: #333
	.body
		padding: 2rem
	input
		border-radius: 0
	button
		margin-top: 0.5rem
		border-radius: calc(2.25rem / 2)
	.title
		font-size: 1.5rem
		margin-bottom: 5px !important
	.flat:focus
		border-bottom-width: 2px
</style>
