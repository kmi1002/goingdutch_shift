<script  src="{{ mix('js/manifest.js') }}"></script>
<script  src="{{ mix('js/vendor.js') }}"></script>
<script  src="{{ mix('js/app.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {
        $('.panel__navigation > ul > li').hover(function () {
            $(this).find('ul').css('display', 'block');
        }, function () {
            if (!$(this).find('ul').hasClass('active')) {
                $(this).find('ul').css('display', 'none');
            }
        });
    });

</script>