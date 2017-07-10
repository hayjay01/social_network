 <div class="media">
 	<a class="pull-left" href="{{ route('profile.index', ['username'=>$user->username]) }}">
	 @if(!$user->profile->profile_image)
 		<img class="media-object" src="{{ $user->getAvatarUrl() }}" alt="{{ $user->getNameOrUsername() }}">
	@else
		<img class="media-object" src="{{ asset($user->profile->profile_image) }}" height="100" width="100" alt="{{ $user->getNameOrUsername() }}">
	@endif
 	</a>
 	<div class="media-body">
 		<h4 class="media-heading"><a href="{{ route('profile.index', ['username'=>$user->username]) }}">{{ $user->getNameOrUsername() }}</a></h4>
 		@if ($user->location)
 			<p>{{ $user->location }}</p>
 		@endif
 	</div>
 </div>