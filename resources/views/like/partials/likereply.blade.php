@foreach ($status->replies as $reply)
	<div class="media">
		<a href="{{ route('profile.index', ['username'=>$reply->user->username]) }}" class="pull-left">
		@if(!$reply->user->profile->profile_image)
			<img src="{{ $reply->user->getAvatarUrl() }}" alt="{{ $reply->user->getNameOrUsername() }}" class="media-object">
		@else
			<img src="{{ asset($reply->user->profile->profile_image) }}" width="70" height="60" alt="{{ $reply->user->getNameOrUsername() }}" class="media-object">
		@endif
		</a>
		<div class="media-body">
			<h5 class="media-heading"><a href="{{ route('profile.index', ['username'=>$reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h5>
			<p>{{ $reply->body }}</p>
			<ul class="list-inline">
				<li>{{ $reply->created_at->diffForHumans() }}</li>
				@if ($reply->user->id !== Auth::user()->id )
					@if(!Auth::user()->hasLikedStatus($reply))
					<li><a href="{{ route('status.like', ['statusId'=>$reply->id]) }}">Like <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span></a></li>
					@else
					<li><i><a href="{{ route('status.dislike', ['statusId'=>$reply->id]) }}">Liked <span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></a></i></li>
					@endif
				@endif
				<li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
			</ul>
		</div>
	</div>
@endforeach