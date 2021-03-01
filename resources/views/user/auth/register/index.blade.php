@extends('user.include.single')

@section('main')
	<h1 id="page-title">{{ __('going.page_title') }}</h1>

	<section class="auth">
		<div class="auth__container">
			<form method="post" action="{{ route('user.auth.signup') }}"  id="signup-form" v-on:submit="onSubmit">
				{{ csrf_field() }}
				<div class="auth-header">
					<h2 class="auth__title">{{ __('register') }}</h2>
					{{--<p class="auth__desc">{{ __('auth.signup.description') }}</p>--}}
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
					@if ( (new \App\Models\UserSocial())->isSocialUser(Session::get('provider'), Session::get('socialiteUser')) )
						<input type="hidden" name="provider" value="{{ Session::get('provider')  }}">
						@if ($email = (new \App\Models\UserSocial())->getEmailFromSociliteUser(Session::get('provider'), Session::get('socialiteUser')))
						<div class="input-field">
							<label>
								<input type="text" name="email" value="{{ $email }}" required readonly>
								<span class="placeholder">{{ __('auth.common.email') }}</span>
							</label>
						</div>
						@else
						<div class="input-field">
							<label>
								<input type="text" name="email" value="{{ old('email') ?? '' }}" required>
								<span class="placeholder">{{ __('auth.common.email') }}</span>
							</label>
						</div>
						@endif
						<div class="input-field">
							<label>
								<input type="text" name="name" value="{{ old('name') ?? '' }}" required>
								<span class="placeholder">{{ __('auth.common.nickname') }}</span>
							</label>
						</div>
						<div class="input-field">
							<label>
								<input type="password" name="password" value="" class="js-user-pass" required v-model="password">
								<span class="placeholder">{{ __('auth.common.password') }}</span>
							</label>
						</div>
						<div class="input-field">
							<label>
								<input type="password" name="password_confirmation" value="" class="js-user-pass-confirm" required v-model="password_confirmation">
								<span class="placeholder">{{ __('auth.common.password_confirm') }}</span>
							</label>
						</div>
					@else
						<div class="input-field">
							<label>
								<input type="text" name="email" value="{{ old('email') ?? '' }}" required>
								<span class="placeholder">{{ __('auth.common.email') }}</span>
							</label>
						</div>
						<div class="input-field">
							<label>
								<input type="text" name="name" value="{{ old('name') ?? '' }}">
								<span class="placeholder">{{ __('auth.common.nickname') }}</span>
							</label>
						</div>
						<div class="input-field__password">
							<label>
								{{--<input type="password" name="password" value="" class="js-user-pass" required v-model="password">--}}
								<vue-password
										v-model="password"
										classes="input"
										name="password"
										required>
								</vue-password>
								<span class="placeholder">{{ __('auth.common.password') }}</span>
							</label>
						</div>
						<div class="input-field__password">
							<label>
								{{--<input type="password" name="password_confirmation" value="" class="js-user-pass-confirm" required v-model="password_confirmation">--}}
								<vue-password
										v-model="password_confirmation"
										classes="input"
										name="password_confirmation"
										required>
								</vue-password>
								<span class="placeholder">{{ __('auth.common.password_confirm') }}</span>
							</label>
						</div>
					@endif
					<div class="">
						<p class="signup-agree mb-20">
							{{ __('auth.signup.agree_text1') }} <a href="{{ route('user.support.terms.index') }}" class="underline">{{ __('auth.signup.agree_terms') }}</a> {{ __('auth.signup.agree_text2') }} <a href="{{ route('user.support.privacy.index') }}" class="underline">{{ __('register') }}</a>
						</p>
						<button type="submit" class="btn-agree mt-10">Signup</button>
						<p class="mt-10"><a href="{{ route('user.auth.signin') }}" class="underline">{{ __('auth.signup.back') }}</a></p>
					</div>

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
				password: '',
				password_confirmation: '',
			},
			methods: {
				onSubmit: function(e) {
					if (this.password != this.password_confirmation) {
						alert("{{ __('auth.alert.different_password') }}");
						e.preventDefault();

						return false;
					}

					return true;
				}
			}
		});
	</script>
@endsection