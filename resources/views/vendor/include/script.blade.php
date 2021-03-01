{{--<script  src="{{ mix('js/manifest.js') }}"></script>--}}
{{--<script  src="{{ mix('js/vendor.js') }}"></script>--}}
<script  src="{{ mix('js/app.js') }}"></script>

<script  type="text/javascript">

    $(document).ready(function() {
        $('.panel__navigation > ul > li').hover(function () {
            $(this).find('ul').css('display', 'block');
        }, function () {
            if (!$(this).find('ul').hasClass('active')) {
                $(this).find('ul').css('display', 'none');
            }
        });

        $('.js-hamburger-menu').click(function() {
            if ($('.panel').is(":visible")) {
                $('.panel').css('display', 'none');
            } else {
                $('.panel').css('display', 'inline-block');
            }
        });
    });

    @if (!\Browser::isDesktop())
    $(document).ready(function(){
        $(window).resize(resizeContents);

        resizeContents();
    });

    function resizeContents() {
        $(".table__responsive").width($(window).width());
    }
    @endif

</script>