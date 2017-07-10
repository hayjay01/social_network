@extends('templates.default')

@section('content')
	<h3>Your Search For "{{ Request::input('query') }}" </h3>

	@if (!$users->count())
		<p>Sorry No result found...</p>
	@else
		<div class="col-lg-12">

			@foreach($users as $user)
				@include('user/partials/userblock')
			@endforeach
		</div>
	@endif
@stop