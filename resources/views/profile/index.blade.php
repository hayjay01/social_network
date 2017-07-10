@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-5"> 
			<!-- user information and status -->
			@include('user.partials.userblock')
			<hr>

				@if(!$statuses->count())
					<p>{{ $user->getFirstNameOrUsername() }} hasnt posted anything yet.</p>
				@else
					@foreach ($statuses as $status)
						<div class="media">
							@include('like.partials.likestatus')
								@include('like.partials.likereply')

								@if ($authUserIsFriend || Auth::user()->id === $status->user->id)
								<form role="form" action="{{ route('status.reply', ['statusId'=>$status->id]) }}" method="post">
									<div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
										<textarea name="reply-{{ $status->id }}" class="form-control" row="2" placeholder="Reply to this status"></textarea>
										@if ($errors->has("reply-{$status->id}"))
											<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
										@endif
									</div>
									<input type="submit" value="Reply" class="btn btn-default btn-sm">
									<input type="hidden" name="_token" value="{{ Session::token() }}">
								</form>
								@endif
							</div>
						</div>
					@endforeach

					
				@endif	
			
		</div>
		<div class="col-lg-4 col-lg-offset-3">
			@if (Auth::user()->hasFriendRequestPending($user))
				<p>Waiting for {{ $user->getNameOrUsername() }} to accept your request</p>
			@elseif (Auth::user()->hasFriendRequestRecieved($user))
				<a href="{{ route('friends.accept', ['username'=>$user->username]) }}" class="btn btn-primary">Accept Friend Request</a>
			@elseif (Auth::user()->isFriendWith($user))
				<p>You are now friend with {{ $user->getNameOrUsername() }}</p>

				<form action="{{ route('friends.delete', ['username'=>$user->username]) }}" method="POST">
					<input type="submit" value="Delete Friend" class="btn btn-primary">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>

			@elseif (Auth::user()->id !==$user->id)
				<a href="{{ route('friends.add', ['username'=>$user->username]) }}" class="btn btn-primary">Add as friend</a>
			@endif
			<h4>{{ $user->getFirstNameOrUsername() }}'s friends</h4>

			@if(!$user->friends()->count())
				<p>{{ $user->getFirstNameOrUsername() }} has no friends.</p>
			@else
				@foreach ($user->friends() as $user)
					@include('user/partials/userblock')
				@endforeach
			@endif
		</div>
	</div>
@stop