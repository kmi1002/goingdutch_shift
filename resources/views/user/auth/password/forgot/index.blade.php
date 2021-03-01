@extends('user.include.single')

@section('main')
                <h1 id="page-title">{{ __('going.page_title') }}</h1>

        		<section class="auth">
        			<div class="auth__container">
        				<form method="post" action="{{ route('user.auth.password.forgot.email') }}" id="forgot_password-form">
							{{ csrf_field() }}

            				<div class="auth-header">
            					<h2 class="auth__title">{{ __('auth.forgot_password.title') }}</h2>
            					<p class="auth__desc">{{ __('auth.forgot_password.description') }}</p>
            				</div>
							<div>
								@if (!empty($errors->first('email')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('email') }}</p>
								@elseif (!empty($errors->first('password_confirmation')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('password_confirmation') }}</p>
								@elseif (!empty($errors->first('password')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('password') }}</p>
								@elseif (!empty($errors->first('name')))
									<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('name') }}</p>
								@endif
							</div>
            				<div class="auth-body">
								<div class="input-field">
									<label>
										<input type="text" name="email" class="email" value="" required>
										<span class="placeholder">{{ __('auth.common.email') }}</span>
									</label>
								</div>
								<button type="submit" class="btn-agree mt-10">{{ __('auth.forgot_password.send_btn') }}</button>
								<p class="mt-10"><a href="{{ route('login') }}" class="underline">{{ __('auth.forgot_password.back') }}</a></p>
            				</div>
        				</form>
        			</div>
        		</section>

@endsection

@section('bottom_scripts')
    <script type="text/javascript">
    </script>
@endsection