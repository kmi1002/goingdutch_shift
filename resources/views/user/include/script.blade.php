{{--<script  src="{{ mix('js/manifest.js') }}"></script>--}}
{{--<script  src="{{ mix('js/vendor.js') }}"></script>--}}
<script  src="{{ mix('js/app.js') }}"></script>

@if (env('APP_ENV') == 'production')
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GA_KEY') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', "{{ env('GA_KEY') }}");
    </script>

    <!-- Facebook Pixel -->
    <script>
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
            n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
            document,'script','https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', {{ env('FACEBOOK_FIXEL_KEY') }});
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ env('FACEBOOK_FIXEL_KEY') }}&ev=PageView&noscript=1" /></noscript>
@endif