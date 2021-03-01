@extends('admin.include.app')

@section('main')

    <table class="popup-table">
        <colgroup>
            <col width="114px" />
            <col width="300px" />
            <col width="114px" />
            <col width="*" />
            <col width="114px" />
            <col width="*" />
        </colgroup>
        <tr>
            <th rowspan="7">대표이미지</th>
            <td rowspan="7" class="store-hero" style="overflow: hidden">
                <div class="swiper-container">
                    <swiper :options="swiperOption" class="swiper-wrapper store-hero__list">
                        <swiper-slide class="swiper-slide store-hero__item">
                            <img src="/img/sample-store-001.jpg" class="store-hero__item-img">
                        </swiper-slide>
                        <swiper-slide class="swiper-slide store-hero__item">
                            <img src="/img/sample-store-002.jpg" class="store-hero__item-img">
                        </swiper-slide>
                        <div class="swiper-pagination swiper-pagination-bullets" slot="pagination"></div>
                    </swiper>
                </div>
{{--                @if ($vendor->files)--}}
{{--                    @foreach($vendor->files as $file)--}}
{{--                        <img src="{{ $file }}">--}}
{{--                    @endforeach--}}
{{--                @else--}}
{{--                    <img src="#">--}}
{{--                @endif--}}
            </td>
            <th>상호명</th>
            <td>{{ $vendor->company }}</td>
            <th>코드</th>
            <td>{{ $vendor->user->email }}</td>
        </tr>
        <tr>
            <th>이름</th>
            <td>{{ $vendor->user->nick_name }}</td>
            <th>이메일</th>
            <td>{{ $vendor->email }}</td>
        </tr>
        <tr>
            <th>주소</th>
            <td>{{ $vendor->address }}</td>
            <th>사업자등록번호</th>
            <td>{{ $vendor->crn }}</td>
        </tr>
        <tr>
            <th>링크</th>
            <td>
                <span>
                    @if ($vendor->home_url)
                        <a href="{{ $vendor->home_url }}" target="_blank" rel="noopener">
                        <i class="ico-home-on"></i>
                    </a>
                    @else
                        <i class="ico-home-off"></i>
                    @endif
                </span>
                <span>
                    @if ($vendor->youtube_url)
                        <a href="{{ $vendor->youtube_url }}" target="_blank" rel="noopener">
                        <i class="ico-youtube-on"></i>
                        </a>
                    @else
                        <i class="ico-youtube-off"></i>
                    @endif
                </span>
                <span>
                    @if ($vendor->facebook_url)
                        <a href="{{ $vendor->facebook_url }}" target="_blank" rel="noopener">
                        <i class="ico-facebook-on"></i>
                        </a>
                    @else
                        <i class="ico-facebook-off"></i>
                    @endif
                </span>
                <span>
                    @if ($vendor->instagram_url)
                        <a href="{{ $vendor->instagram_url }}" target="_blank" rel="noopener">
                        <i class="ico-instagram-on"></i>
                        </a>
                    @else
                        <i class="ico-instagram-off"></i>
                    @endif
                </span>
                <span>
                    @if ($vendor->naver_url)
                        <a href="{{ $vendor->naver_url }}" target="_blank" rel="noopener">
                        <i class="ico-naver-on"></i>
                        </a>
                    @else
                        <i class="ico-naver-off"></i>
                    @endif
                </span>

                <span>
                    @if ($vendor->kakaoplus_url)
                        <a href="{{ $vendor->kakaoplus_url }}" target="_blank" rel="noopener">
                        <i class="ico-kakaoplus-on"></i>
                        </a>
                    @else
                        <i class="ico-kakaoplus-off"></i>
                    @endif
                </span>
            </td>
        </tr>
        <tr>
            <th>소개</th>
            <td colspan="4">{{ $vendor->introduce }}</td>
        </tr>
    </table>
    <hr>

    <a href="{{ route('admin.vendor.menu.index', ['vendor' => $vendor->id]) }}">메뉴로 이동하기</a>
@endsection

@section('bottom_scripts')

@endsection