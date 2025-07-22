<?php

$locale = app()->getLocale();


$available_locales = Config::get("app.available_locales");
$current_locale = App::getLocale();
$available_currencies = Config::get("site.currencies");
$current_currency = Config::get('site.current_currency');
$path = parse_url(url()->current(), PHP_URL_PATH);
$locale = app()->getLocale();
$current_locale = app()->getLocale();
$brands = Config::get('site.brands');
$bodies = Config::get('site.bodies');
$types = Config::get('site.types');
$cities = Config::get('site.cities');
?>


<footer>
    <div class="footer_content">
        @if(count($brands) > 1)
            <div class="footer_dropdown close">
                <div class="dropdown_title">
                    <p>{{ trans('front.header.brands') }}</p>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.9997 9.1697C16.8123 8.98345 16.5589 8.87891 16.2947 8.87891C16.0305 8.87891 15.7771 8.98345 15.5897 9.1697L11.9997 12.7097L8.4597 9.1697C8.27234 8.98345 8.01889 8.87891 7.7547 8.87891C7.49052 8.87891 7.23707 8.98345 7.0497 9.1697C6.95598 9.26266 6.88158 9.37326 6.83081 9.49512C6.78004 9.61698 6.75391 9.74769 6.75391 9.8797C6.75391 10.0117 6.78004 10.1424 6.83081 10.2643C6.88158 10.3861 6.95598 10.4967 7.0497 10.5897L11.2897 14.8297C11.3827 14.9234 11.4933 14.9978 11.6151 15.0486C11.737 15.0994 11.8677 15.1255 11.9997 15.1255C12.1317 15.1255 12.2624 15.0994 12.3843 15.0486C12.5061 14.9978 12.6167 14.9234 12.7097 14.8297L16.9997 10.5897C17.0934 10.4967 17.1678 10.3861 17.2186 10.2643C17.2694 10.1424 17.2955 10.0117 17.2955 9.8797C17.2955 9.74769 17.2694 9.61698 17.2186 9.49512C17.1678 9.37326 17.0934 9.26266 16.9997 9.1697Z"
                            fill="#201E2E"/>
                    </svg>
                </div>
                <div class="dropdown_content">
                    @foreach($brands as $brand)
                        <a class="footer-link"
                           href="{{brandUrl($brand->slug)}}">{{$brand['name'] }}</a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="footer_prebottom_links">


            @if(count($types) > 1)
                <div class="block">
                    <p class="block_title">{{ trans('front.header.types') }}</p>

                    @foreach($types as $type)
                        <a class="footer-link"
                           href="{{typeUrl($type->slug)}}">{{$type['name'] }}</a>
                    @endforeach

                </div>
            @endif
            @if(count($bodies) > 1)
                <div class="block">
                    <p class="block_title">{{ trans('front.header.bodiess') }}</p>
                    @foreach($bodies as $body)
                        <a class="footer-link"
                           href="{{bodyUrl($body->slug)}}">{{$body['name'] }}</a>
                    @endforeach
                </div>
            @endif
            @if(count($cities) > 1)
                <div class="block">
                    <p class="block_title">{{ trans('front.header.cities') }}</p>
                    @foreach($cities as $city)
                        <a class="footer-link"
                           href="{{cityUrl($city->slug)}}">{{$city['name'] }}</a>
                    @endforeach
                </div>
            @endif
            @if(count($available_currencies) > 1)
                <div class="block">
                    <p class="block_title">{{ trans('front.header.currencies') }}</p>
                    @foreach($available_currencies as $currency)
                        @if($currency == $current_currency)
                            <span class="footer-link current"
                                  data-sign="{{ $currency->sign }}">{{ strtoupper($currency->slug) }}</span>
                        @else
                            <span class="footer-link currency-switch"
                                  data-sign="{{ $currency->sign }}">{{ strtoupper($currency->slug) }}</span>
                        @endif
                    @endforeach
                </div>
            @endif
            @if(count($available_locales) > 1)
                <div class="block">
                    <p class="block_title">{{ trans('front.header.languages') }}</p>
                    @foreach($available_locales as $language)
                        @php
                            $uri = $_SERVER['REQUEST_URI'];
                            $uri = parse_url($uri)['path'];
                            $locale = $language->code;
                            // Replace the current locale in the URL with the new locale
                            if ($current_locale !== Config::get("app.fallback_locale")) {
                                $uri = substr($uri, 3); // Remove the current locale prefix
                            }
                            $uri = ($locale === Config::get("app.fallback_locale")) ? $uri : "/$locale$uri";
                            $name = $language->title;
                            // Ensure no trailing slash
                            $uri = preg_replace('/(?<=.)\/$/', '', $uri);
                            $uri = $uri ?: '/';
                        @endphp
                        @if($locale == $current_locale)
                            <span class="footer-link current">{{ $name }}</span>

                        @else
                            <a class="footer-link"
                               href="{{$uri}}">{{$name }}</a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        <div class="footer_content_bottom">
            <div class="footer_content_payment">
                <img src="/images/payment/payment1.svg" alt="MasterCard" loading="lazy"/>
                <img src="/images/payment/payment2.svg" alt="Visa" loading="lazy"/>
                <img src="/images/payment/payment3.svg" alt="MasterCard SecureCode"
                     loading="lazy"/>
                <img src="/images/payment/payment4.svg" alt="Verified by Visa" loading="lazy"/>
            </div>
            <div class="footer-bottom">
                <div class="bottom-text">{{date('Y')}} © RENTACAR</div>
            </div>
        </div>
    </div>
</footer>

