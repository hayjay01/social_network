@extends('templates.default')

@section('content')
	<div class="row">
		<div class="col-lg-1">
			<img style="float:right;" src="{{ asset(Auth::user()->profile->profile_image) }}" alt="" class="img-rounded" height="40" width="50" >
		</div>
		<div class="col-lg-6">
			<form role="form" action="{{ route('status.post') }}" method="post" enctype="multipart/form-data" >

				<div class="form-group{{ $errors->has('status') ? ' has-error': '' }}">
					<textarea name="status" placeholder="whats up {{ Auth::user()->getFirstNameOrUsername() }}?" class="form-control" rows="4" col="7"></textarea>
					@if ($errors->has('status'))
						<span class="help-block">{{ $errors->first('status') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('image.*') ? ' has-error': '' }}">
					<input type="file" name="image[]" class="form-control" multiple />
					
					@if ($errors->has('image.*'))
						<span class="help-block">{{ $errors->first('image.*') }}</span>
					@endif
				</div>
				<button type="submit" class="btn btn-default">Update Status</button>
				<input type="hidden" name="_token" value="{{ Session::token() }}" >
			</form>
			<hr>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-8">
			@if(!$statuses->count())
				<p>There's no status on your timeline</p>
			@else
				@foreach ($statuses as $status)
					<div class="media">
						@include('like.partials.likestatus')
							@include('like.partials.likereply')
							<form role="form" action="{{ route('status.reply', ['statusId'=>$status->id]) }}" method="post">
								<div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
									<textarea name="reply-{{ $status->id }}" class="form-control" row="6" col="6" placeholder="Reply to this status"></textarea>
									@if ($errors->has("reply-{$status->id}"))
										<span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
									@endif
								</div>
								<input type="submit" value="Reply" class="btn btn-default btn-sm">
								<input type="hidden" name="_token" value="{{ Session::token() }}">
							</form>
						</div>
					</div>
				@endforeach


			@endif	
		</div>
	</div>
	
@stop