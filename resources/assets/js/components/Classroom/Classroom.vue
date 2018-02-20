<template>
	<div class="card pointer" v-if="!fake">
	  <header class="card-header relative" :style="`--color: ${item.color || '#333'}`">
	    <span class="text-bold">{{ item.name }}</span>
	    <small v-if="item.master.id !== user.id">{{ item.master.name }}</small>
	    <small v-else>Criada por mim</small>
      <img v-if="item.master.id !== user.id" :src="item.master.photo" alt="Image">
	  </header>
	  <div class="card-content">
	    <div class="content">
	    </div>
	  </div>
	</div>
	<section class="ghost" v-else>
		<i class="icon icon-plus fa-4x"></i>
		<span>Adicionar classe</span>
	</section>
</template>

<script>
	export default {
		name: 'ClassComponent',
		props: {
			name: String,
			fake: Boolean,
			item: Object
		},
		computed: {
			user: function () {
				return this.$store.getters.user
			}
		}
	}
</script>

<style lang="sass" scoped>
	section, #teach-component .card
		border-radius: 3px
	section
		--color: #666
		display: flex
		flex-direction: column
		align-items: center
		justify-content: center
		border: 3px dashed var(--color)
		color: var(--color)
		i
			margin-bottom: .5rem
	#teach-component
		.ghost
			min-height: 9rem
			height: 100%
		.card-header
			background-color: var(--color)
			color: white
			flex-direction: column;
			padding: 1rem
		.card
			overflow: hidden
			margin-bottom: 0
			box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1)
			img
				max-width: 30%
				border-radius: 50%
				position: absolute
				bottom: 0
				margin-bottom: 0
				transform: translateY(50%)
				right: 10px
		p
			margin-bottom: 0
</style>
