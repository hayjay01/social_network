<a href="{{ route('profile.index', ['username'=>$status->user->username]) }}" class="pull-left">
	@if(!$status->user->profile->profile_image)
	<img src="{{ $status->user->getAvatarUrl() }}" alt="{{ $status->user->getNameOrUsername() }}" class="media-object">
	@else
	<img src="{{ asset($status->user->profile->profile_image) }}" width="70" height="60" alt="{{ $status->user->getNameOrUsername() }}" class="media-object">
	@endif
</a>
<div class="media-body">
	<h4 class="media-heading"><a href="{{ route('profile.index', ['username'=>$status->user->username]) }}">{{ $status->user->getNameOrUsername() }}</a></h4>
	<p>{{ $status->body }}</p>
	{{-- <p>{{ $status->image }}</p> --}}
	
	<div class="row">
	@foreach($status->images as $images)
	<div class="col-lg-6">
	<p><img src="{{ asset($images->image) }}" alt="" class="img-rounded img-responsive"> </p>
	</div>
	@endforeach
	</div>
	
	<ul class="list-inline">
		<li>{{ $status->created_at->diffForHumans() }}</li>
		@if ($status->user->id !== Auth::user()->id)
			@if(!Auth::user()->hasLikedStatus($status))
			<li><a href="{{ route('status.like', ['statusId'=>$status->id]) }}" id="like">Like <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span></a></li>
			@else
			<li><i><a href="{{ route('status.dislike', ['statusId'=>$status->id]) }}" id="liked">Liked <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></a></i></li>
			@endif
		@endif
		<li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
	</ul> 
	