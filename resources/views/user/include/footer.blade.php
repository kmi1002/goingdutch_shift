<footer class="footer">
    <div class="footer__container">
{{--        <div class="row">--}}
{{--            <p class="footer__info">{{ $vendor->address }}</p>--}}
{{--            <p class="footer__info">대표 : {{ $vendor->user->getUserName() }}<span class="ml-20">사업자등록번호 : {{ $vendor->crn }}</span></p>--}}
{{--            <p class="footer__copyright">Copyright ⓒ {{ $vendor->company }} Corp. All Rights Reserved.</p>--}}
{{--        </div>--}}
        <div class="row" style="padding: 10px 0">
            <p class="footer__info"><span>올댓컴즈(all that comms)</span><span class="ml-20">대표 : {{ $vendor->user->getUserName() }}</span></p>
            <p class="footer__info"><span>사업자등록번호 : {{ $vendor->crn }}</span><span class="ml-20">통신판매업번호 : 2018-서울마포-1259</span></p>
            <p class="footer__info">{{ $vendor->address }}</p>
            <p class="footer__info"><span>고객센터 : 070-4336-2244</span><span class="ml-20">이메일 : allthatcomms@naver.com</span></p>
            <p class="footer__copyright">Copyright ⓒ 올댓컴즈(all that comms) Corp. All Rights Reserved.</p>
        </div>
    </div>
</footer>