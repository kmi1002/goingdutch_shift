@extends('user.include.single')

@section('main')
    <h1 id="page-title">{{ __('going.page_title') }}</h1>

    <section class="auth">
        <div class="auth__container">
            <form method="post" action="{{ route('user.auth.withdrawal.confirm') }}"  id="signup-form">
                {{ csrf_field() }}
                <div class="auth-header">
                    <h2 class="auth__title">{{ __('auth.withdrawal.title') }}</h2>
                    <p class="auth__desc">{{ __('auth.withdrawal.description') }}</p>
                </div>
                <div>
                    @if (!empty($errors->first('password_confirmation')))
                        <p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('password_confirmation') }}</p>
                    @elseif (!empty($errors->first('reason')))
                        <p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('reason') }}</p>
                    @elseif (!empty($errors->first('withdrawal_user')))
                        <p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('withdrawal_user') }}</p>
                    @endif
                </div>
                <div class="auth-body">
                    <!--<div class="input-field">
                        <div class="select-wrapper">
                            <select name="reason">
                                <option value=""  disabled selected>{{ __('auth.withdrawal.select') }}</option>
                                <option value="{{ __('auth.withdrawal.option1') }}">{{ __('auth.withdrawal.option1') }}</option>
                            </select>
                        </div>
                        <label>
                            <span>{{ __('auth.withdrawal.reason') }}</span>
                        </label>
                    </div>-->
                    <div class="input-field">
                        <label>
                            <input type="password" name="password" value="" class="js-user-pass" required>
                            <span class="placeholder">{{ __('auth.common.password') }}</span>
                        </label>
                    </div>
                    <div class="input-field">
                        <label>
                            <input type="password" name="password_confirmation" value="" class="js-user-pass-confirm" required>
                            <span class="placeholder">{{ __('auth.common.password_confirm') }}</span>
                        </label>
                    </div>
                    <div>
                        <button type="submit" class="btn-agree mt-10">{{ __('auth.withdrawal.withdrawal_btn') }}</button>
                        <p class="mt-10"><a href="{{ route('user') }}" class="underline">{{ __('auth.withdrawal.back') }}</a></p>
                    </div>

                </div>
            </form>
        </div>
    </section>
@endsection

@section('bottom_scripts')
    <script type="text/javascript">

    </script>
@endsection