@extends('user.include.mail')

@section('main')
	<main class="main">
		<div class="main__container">
			<section class="mail">
				<div class="mail__container">
					<form action="{{ route('user.auth.password.forgot.reset') . '/' . $token }}">
						<div class="mail__header">
							<img src="{{ env('AWS_S3_ASSESST_V1_URL').'logo_kstarlive_black.svg' }}" alt="kstarlive" class="main-logo">
							<p class="mail__title">{{ __('auth.email_password.title') }}</p>
						</div>
						<div class="mail__body">
							<p class="mail__desc">{{ __('auth.email_password.description') }}</p>
							<button type="submit" class="btn-agree">{{ __('auth.email_password.password_btn') }}</button>
						</div>
						<div class="mail__footer">
						</div>
					</form>
				</div>
			</section>
		</div>
	</main>
@endsection

@section('bottom_scripts')

@endsection