@extends('user.include.single')

@section('main')
    <!-- 가로 광고 영역 -->
    {{--@include('frontend.components.view.ad.horizontal')--}}
    <!-- 가로 광고 영역 끝 -->

    <h1 id="page-title">{{ __('going.page_title') }}</h1>

    <section class="auth">
        <div class="auth__container">
            <form method="post" action="{{ route('user.auth.certification.reset') }}" id="signin-form">
                {{ csrf_field() }}
                <div class="auth-header">
                    <h2 class="auth__title">{{ __('auth.certification.title') }}</h2>
                    {{--<p class="auth__desc">{{ __('auth.certification.description') }}</p>--}}
                </div>
                <div class="auth-body">
                    <div class="input-field">
                        <label>
                            <input type="text" name="email" value="" required autofocus>
                            <span class="placeholder">{{ __('auth.common.email') }}</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-agree mt-10">{{ __('auth.certification.send_btn') }}</button>
                </div>
            </form>
        </div>
    </section>

    <!-- 가로 광고 영역 -->
    {{--@include('frontend.components.view.ad.horizontal')--}}
    <!-- 가로 광고 영역 끝 -->

@endsection

@section('bottom_scripts')
    <script type="text/javascript">
    </script>
@endsection