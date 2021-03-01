@extends('user.include.app-service')

@section('main')
    <div class="service">
        <h1 id="page-title">{{ __('going.page_title') }}</h1>
        <ul class="vendor__list">
            @foreach ($vendors as $vendor)
            <li class="vendor__item"><a href="{{ route('user.menu.index', ['id' => $vendor->id]) }}" >{{ $vendor->company }}로 바로가기</a></li>
            @endforeach
        </ul>
    </div>
@endsection