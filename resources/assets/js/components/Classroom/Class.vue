<template>
	<div class="card" v-if="!fake">
	  <header class="card-header relative">
	    <span class="text-bold">Component</span>
	    <small>Jorge da capadócia</small>
      <img src="http://bulma.io/images/placeholders/64x64.png" alt="Image">
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
			fake: Boolean
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
		.card-header
			background-color: gold
			color: white
			flex-direction: column;
			padding: 1rem
		.card
			margin-bottom: 0
			box-shadow: 0 2px 3px rgba(10, 10, 10, 0.1), 0 0 0 1px rgba(10, 10, 10, 0.1)
			img
				border-radius: 50%
				position: absolute
				bottom: 0
				margin-bottom: 0
				transform: translateY(50%)
				right: 10px
		p
			margin-bottom: 0
</style>
