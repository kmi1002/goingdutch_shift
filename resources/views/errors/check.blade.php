@extends('errors.app')

@section('imageAttribute', ' src=/user/images/common/error_icn02.png ')

@section('h1Text')
    {{ __('error.check.title') }}
@endsection

@section('h2Text')
    {!!  __('error.check.description') !!}
@endsection
