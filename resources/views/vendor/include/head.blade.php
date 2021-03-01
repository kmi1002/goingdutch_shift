    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} 관리자</title>
    <meta name="description" content="{{ __('going.head.description') }}">
    <meta name="keywords" content="{{ __('going.head.keywords') }}">
    <meta name="author" content="{{ __('going.head.author') }}">

    <!-- Bot Tag -->
    <meta name="robots" content="follow">
    <meta name="googlebot" content="noindex">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheet include -->
    <link rel="stylesheet" type="text/css" href="{{ mix('css/admin.css')}}">