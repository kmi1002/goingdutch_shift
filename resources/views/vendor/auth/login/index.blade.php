<!doctype html>
<html>
<head>
    @include('vendor.include.head')
</head>
<body>
<div id="wrap">
    <main class="main">
        <section class="auth">
            <div class="auth__container">
                <form method="post" action="{{ route('vendor.auth.login') }}">
                    {{ csrf_field() }}
                    <div class="auth__header">
                        <p class="auth__title">점주 {{ __('auth.login.title') }}</p>
                        {{--                                <p class="auth__desc">{{ __('auth.login.description') }}</p>--}}
                    </div>
                    @if ($errors->any())
                        <div class="auth__warning">
                            <p class="warning__desc"><i class="ico-auth-warning"></i>{{ $errors->first('warning_login') }}</p>
                        </div>
                    @endif
                    <div class="auth__body">
                        <div class="input-field">
                            <label>
                                <input type="text" name="email" value="{{ old('email') ?? '' }}" required autofocus>
                                <span class="placeholder">아이디</span>
                            </label>
                        </div>
                        <div class="input-field">
                            <label>
                                <input type="password" name="password" value="" required>
                                <span class="placeholder">{{ __('auth.common.password') }}</span>
                            </label>
                        </div>
                        <button type="submit" class="btn-agree mt-10">Login</button>
                    </div>
                    <div class="auth__footer">
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>
@include('admin.include.script')
</body>
</html>
