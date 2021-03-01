@extends('errors.app')

@section('imageAttribute', ' src=/user/images/common/error_icn01.png ')

@section('h1Text')

    @if(request()->query('errorcode'))
        Error Code: {{ request()->query('errorcode') }}
    @else
        {{ __('error.403.title') }}
    @endif

@endsection

@section('h2Text')

    @if(request()->query('errormsg'))
        {{ request()->query('errormsg') }}
    @else
        {!!  __('error.403.description') !!}
    @endif

@endsection
