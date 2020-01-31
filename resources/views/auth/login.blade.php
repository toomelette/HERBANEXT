@extends('layouts.guest-master')
@section('content')

<section class="content">
	<div class="col-md-3"></div>
	<div class="col-md-6">

		@if(Session::has('AUTH_AUTHENTICATED'))
			{!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Oops!', Session::get('AUTH_AUTHENTICATED')) !!}
		@endif

		@if(Session::has('AUTH_UNACTIVATED'))
			{!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Oops!', Session::get('AUTH_UNACTIVATED')) !!}
		@endif

		@if(Session::has('CHECK_UNAUTHENTICATED'))
			{!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Oops!', Session::get('CHECK_UNAUTHENTICATED')) !!}
		@endif

		@if(Session::has('CHECK_NOT_LOGGED_IN'))
			{!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Oops!', Session::get('CHECK_NOT_LOGGED_IN')) !!}
		@endif

		@if(Session::has('CHECK_NOT_ACTIVE'))
			{!! __html::alert('danger', '<i class="icon fa fa-ban"></i> Oops!', Session::get('CHECK_NOT_ACTIVE')) !!}
		@endif

		@if(Session::has('PROFILE_UPDATE_USERNAME_SUCCESS'))
			{!! __html::alert('success', '<i class="icon fa fa-check"></i> Success!', Session::get('PROFILE_UPDATE_USERNAME_SUCCESS')) !!}
		@endif

		@if(Session::has('PROFILE_UPDATE_PASSWORD_SUCCESS'))
			{!! __html::alert('success', '<i class="icon fa fa-check"></i> Success!', Session::get('PROFILE_UPDATE_PASSWORD_SUCCESS')) !!}
		@endif

		<div class="box box-default">
			<div class="box-header with-border">
				<h3 class="box-title">Login</h3>
			</div>
			<form class="form-horizontal" method="POST" action="{{ route('auth.login') }}">
				
				@csrf
				<div class="box-body">
					<div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
						<label for="username" class="col-sm-2 control-label">Username</label>
						<div class="col-sm-10">
							<input class="form-control is-invalid" name="username" id="username" placeholder="Username" type="text" value="{{ __sanitize::html_attribute_encode(old('username')) }}">
							
							@if ($errors->has('username'))
							<span class="help-block"> {{ $errors->first('username') }} </span>
							@endif
						</div>
					</div>
					<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<label for="password" class="col-sm-2 control-label">Password</label>
						<div class="col-sm-10">
							<input class="form-control" name="password" id="password" placeholder="Password" type="password">
							@if ($errors->has('password'))
							<span class="help-block">{{ $errors->first('password') }}</span>
							@endif
						</div>
					</div>
				</div>
				
				<div class="box-footer">
					<button type="submit" class="btn btn-default">Sign in</button>
				</div>
				
			</form>
		</div>

	</div>
	<div class="col-md-3"></div>
</section>
@endsection
