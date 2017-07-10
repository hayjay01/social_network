@extends('templates.default')

@section('content')
	<h3>Update your Profile</h3>

	<div class="row">
		{{-- displaying the profile image --}}
		<div class="col-lg-6">
			<div class="row">
				<div class="col-lg-3 col-lg-offset-2">
					@if(!Auth::user()->profile->profile_image)
					<img src="{{ Auth::user()->getAvatarUrl() }}" alt="{{ Auth::user()->getNameOrUsername() }}" class="img-rounded" width="304" height="236" >
					@else
					<img src="{{ asset(Auth::user()->profile->profile_image) }}" alt="{{ Auth::user()->username }}" class="img-rounded" width="304" height="236" >
					@endif
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<form class="form-vertical" role="form" method="post" enctype="multipart/form-data" action="{{ route('profile.edit') }}">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('first_name') ? ' has-error': '' }}">
							<label class="control-label" for="first_name">First Name</label>
							<input type="text" name="first_name" class="form-control" id="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
							@if($errors->has('first_name'))
								<span class="help-block">{{ $errors->first('first_name') }}</span>
							@endif
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group{{ $errors->has('last_name') ? ' has-error': '' }}">
							<label class="control-label" for="last_name">Last Name</label>
							<input type="text" name="last_name" class="form-control" id="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
							@if($errors->has('last_name'))
								<span class="help-block">{{ $errors->first('last_name') }}</span>
							@endif
						</div>
					</div>
				</div>
				<div class="form-group{{ $errors->has('phone_number') ? ' has-error': '' }}">
					<label class="control-label" for="phone_number">Phone Number</label>
					<input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ Request::old('phone_number') ?: Auth::user()->profile->phone_number }}">
					@if($errors->has('phone_number'))
						<span class="help-block">{{ $errors->first('phone_number') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('department') ? ' has-error': '' }}">
					<label class="control-label" for="department">Department</label>
					<input type="text" name="department" class="form-control" id="department" value="{{ Request::old('department') ?: Auth::user()->profile->department }}">
					@if($errors->has('department'))
						<span class="help-block">{{ $errors->first('department') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('level') ? ' has-error': '' }}">
					<label class="control-label" for="level">Level</label>
					<input type="text" name="level" class="form-control" id="level" value="{{ Request::old('level') ?: Auth::user()->profile->level }}">
					@if($errors->has('level'))
						<span class="help-block">{{ $errors->first('level') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('profile_picture') ? ' has-error': '' }}">
					<label class="control-label" for="level">Profile Picture</label>
					<input type="file" name="profile_picture" class="form-control" id="profile_picture" >
					@if($errors->has('profile_picture'))
						<span class="help-block">{{ $errors->first('profile_picture') }}</span>
					@endif
				</div>
				<div class="form-group{{ $errors->has('address') ? ' has-error': '' }}">
					<label class="control-label" for="level">Address</label>
					<textarea name="address" id="address" cols="30" class="form-control" rows="10">{{ Request::old('address') ?: Auth::user()->profile->address }}</textarea>
					@if($errors->has('address'))
						<span class="help-block">{{ $errors->first('address') }}</span>
					@endif
				</div>	
				<div class="form-group{{ $errors->has('location') ? ' has-error': '' }}">
					<label class="control-label" for="location">State and Country</label>
					<input type="text" name="location" class="form-control" id="location" value="{{ Request::old('location') ?: Auth::user()->location }}">
					@if($errors->has('location'))
						<span class="help-block">{{ $errors->first('location') }}</span>
					@endif
				</div>
					
				<div class="form-group">
					<button type="submit" class="btn btn-default">Update Profile</button>
				</div>
				<input type="hidden" name="_token" value="{{ Session::token() }}" >
			</form>
		</div>
	</div>
@stop