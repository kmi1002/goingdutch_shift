    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>
    <meta name="description" content="{{ __('going.head.description') }}">
    <meta name="keywords" content="{{ __('going.head.keywords') }}">
    <meta name="author" content="{{ __('going.head.author') }}">

    {{-- Facebook Tag --}}
    <meta property="fb:pages" content="{{ env('FACEBOOK_PAGE_ID') }}">
    <meta property="fb:app_id" content="{{ env('FACEBOOK_APP_ID') }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ URL::current() }}">
    <meta property="og:site_name" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ env('APP_NAME') }}">
    <meta property="og:description" content="{{ __('going.head.description') }}">
    <meta property="og:image" content="{{ env('AWS_S3_ASSESST_V1_URL').'meta.jpg' }}">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="720">

    {{-- Twitter Tag --}}
    <meta name="twitter:card" content="photo">
    <meta name="twitter:url" content="{{ env('APP_URL') }}">
    <meta name="twitter:title" content="{{ env('APP_NAME') }}">
    <meta name="twitter:description" content="{{ __('going.head.description') }}">
    <meta name="twitter:image" content="{{ env('AWS_S3_ASSESST_V1_URL').'meta.jpg' }}">
    <meta name="twitter:site" content="@kstarlivecom">
    <meta name="twitter:creator" content="@kstarlivecom">

    {{-- Pinterest Tag --}}
    <meta name="p:domain_verify" content=""/>

    {{-- Naver Tag --}}
    <meta name="naver-site-verification" content="{{ env('NAVER_SITE_VERIFICATION') }}">

    {{-- Google Tag --}}
    <meta name="google-site-verification" content="{{ env('GOOGLE_SITE_VERIFICATION') }}">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_72.png' }}">
    <link rel="apple-touch-icon" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_60.png' }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_76.png' }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_120.png' }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_152.png' }}">
    <link rel="apple-touch-icon-precomposed" href="{{ env('AWS_S3_ASSESST_V1_URL').'favicon_60.png' }}">

    {{-- Stylesheet --}}
    <link rel="stylesheet" type="text/css" href="{{ mix('css/style.css')}}">