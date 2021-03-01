@extends('user.include.app-mobile')

@section('custom_style')
	<style>

	</style>
@endsection

@section('main')
                <h1 id="page-title">{{ __('going.page_title') }}</h1>

        		<section class="auth">
        			<div class="auth__container">

        				<form method="post" action="{{ route('user.auth.login') }}" id="signin-form">
							{{ csrf_field() }}
            				<div class="auth-header">
            					<h2 class="auth__title">{{ __('auth.signin.title') }}</h2>
{{--            					<p class="auth__desc">{{ __('auth.signin.description') }}</p>--}}
							</div>
							<div>
								@if (!empty($errors->first('warning_signin')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('warning_signin') }}</p>
								@endif
								@if (!empty($errors->first('not_user')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('not_user') }}</p>
								@endif
								@if (!empty($errors->first('password')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('password') }}</p>
								@endif
								@if (!empty($errors->first('userSocialsError')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('userSocialsError') }}</p>
								@endif
								@if (!empty($errors->first('withdrawal_user')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('withdrawal_user') }}</p>
								@endif
							</div>
            				<div class="auth-body">
            					<div class="input-field">
									<label>
										<input type="text" name="email" value="" required autofocus>
										<span class="placeholder">{{ __('auth.common.email') }}</span>
									</label>
								</div>
								<div class="input-field__password mb-10">
									<label>
										<input type="password" name="password" value="" required>
										<span class="placeholder">{{ __('auth.common.password') }}</span>
									</label>
								</div>
								<button type="submit" class="btn-agree">{{ __('auth.signin.signin_btn') }}</button>
								<p class="mt-10 mb-10">{{ __('auth.signin.not_user') }}<a href="{{ route('user.auth.register.form') }}" class="underline"> {{ __('register') }}</a></p>
								<p class="pass-forgot"><a href="{{ route('user.auth.password.forgot') }}" class="underline">{{ __('auth.forgot_password.title') }}</a></p>
            					<div class="divider">
            						<span>or</span>
            					</div>
        						<ul class="social__list">
        							<li class="social__item">
        								<a href="{{ url('/oauth/facebook') }}" class="btn-facebook">{{ __('login') }}</a>
        							</li>
        						</ul>
							</div>
        				</form>
        			</div>
        		</section>
	
@endsection

@section('bottom_scripts')
    <script>
		new Vue({
			el: '#wrap',
			data: {
				password: ''
			}
		})
    </script>
@endsection