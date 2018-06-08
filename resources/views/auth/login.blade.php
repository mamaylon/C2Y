@extends('layouts.app')

@section('content')
<section class="container login-container">
	<div class="row margin-bottom">
		<div class="columns is-12 has-text-centered login">
			<div class="is-fullwidth">
				<h1 class="has-text-centered relative">Conecte-se utilizando o Google :)</h1>
			</div>
		</div>
	</div>
	<div class="row margin-top">
		<div class="columns is-12 has-text-centered login">
			<div class="is-fullwidth">
				<!--<a href="/redirect" class="facebook flat social facebook-text">
					<i class="fa fa-facebook" aria-hidden="true"></i>
				</a>-->
				<a href="/redirect/google" class="google flat social google-text">
					<i class="fa fa-google-plus" aria-hidden="true"></i>
				</a>
			</div>
		</div>
	</div>
</section>
@endsection
