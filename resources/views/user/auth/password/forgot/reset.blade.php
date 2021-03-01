@extends('user.include.single')

@section('main')

				<h1 id="page-title">{{ __('going.page_title') }}</h1>
        		<section class="auth">
        			<div class="auth__container">
        				<form method="post" action="{{ route('user') }}" id="change_password-form" v-on:submit="onSubmit">
							{{ csrf_field() }}

							<input type="hidden" name="token" value="{{ $token }}">
							<div class="auth-header">
        						<h2 class="auth__title">{{ __('auth.change_password.title') }}</h2>
            					{{--<p class="auth__desc">{{ __('auth.change_password.description') }}</p>--}}
								<div>
									@if (!empty($errors->first('forgot_password')))
										<p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('forgot_password') }}</p>
									@endif
								</div>
        					</div>
        					<div class="auth-body">
								{{--<div class="input-field">--}}
									{{--<label>--}}
										{{--<input type="password" name="old_password" class="user-pass js-user-pass" value="" required v-model="old_password">--}}
										{{--<span class="placeholder">{{ __('auth.change_password.old_password') }}</span>--}}
									{{--</label>--}}
								{{--</div>--}}
								<div class="input-field">
									<label>
										<vue-password
												v-model="password"
												classes="input"
												name="password"
												required>
										</vue-password>
										{{--<input type="password" name="password" class="user-pass js-user-pass" value="" required v-model="password">--}}
										<span class="placeholder">{{ __('auth.change_password.new_password') }}</span>
									</label>
								</div>
								<div class="input-field">
									<label>
										<vue-password
												v-model="password_confirmation"
												classes="input"
												name="password_confirmation"
												required>
										</vue-password>
										{{--<input type="password" name="password_confirmation" class="user-pass-confirm js-user-pass-confirm" value="" required v-model="password_confirmation">--}}
										<span class="placeholder">{{ __('auth.change_password.new_password_confirm') }}</span>
									</label>
								</div>
								<button type="submit" class="btn-agree mt-10">{{ __('auth.change_password.change_btn') }}</button>
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
				old_password: '',
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