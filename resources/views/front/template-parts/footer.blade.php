<?php
$site_menu = Config::get('services.site_config.site_menu');
$site_menu = $site_menu !== null ? $site_menu->where('site_id', '=', $site->id)->where("footer", 1)->sortByDesc('sorter') : \App\Models\SiteMenu::query()->where('site_id', '=', $site->id)->where("footer", 1)->orderBy('sorter')->get();

$current_locale = App::getLocale();
$available_locales = Config::get("app.available_locales");
$partners = (new \App\Models\SitePartner)->getSitePartners($site->id);
$partners=$partnersNew??$partners;
$siteThemeTemplate = $site->theme->template;
$path = parse_url(url()->current(), PHP_URL_PATH);
$terms = checkTerms($pages);
$locale = app()->getLocale();

$currentLocal = app()->getLocale();

?>


<footer>
    <div class="footer_content">
        @foreach($site_menu as $menu)
            @if($menu->link == Config::get('services.areas_link'))
                <div class="footer_dropdown close">
                    <div class="dropdown_title">
                        <p>{{$menu->name}}</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.9997 9.1697C16.8123 8.98345 16.5589 8.87891 16.2947 8.87891C16.0305 8.87891 15.7771 8.98345 15.5897 9.1697L11.9997 12.7097L8.4597 9.1697C8.27234 8.98345 8.01889 8.87891 7.7547 8.87891C7.49052 8.87891 7.23707 8.98345 7.0497 9.1697C6.95598 9.26266 6.88158 9.37326 6.83081 9.49512C6.78004 9.61698 6.75391 9.74769 6.75391 9.8797C6.75391 10.0117 6.78004 10.1424 6.83081 10.2643C6.88158 10.3861 6.95598 10.4967 7.0497 10.5897L11.2897 14.8297C11.3827 14.9234 11.4933 14.9978 11.6151 15.0486C11.737 15.0994 11.8677 15.1255 11.9997 15.1255C12.1317 15.1255 12.2624 15.0994 12.3843 15.0486C12.5061 14.9978 12.6167 14.9234 12.7097 14.8297L16.9997 10.5897C17.0934 10.4967 17.1678 10.3861 17.2186 10.2643C17.2694 10.1424 17.2955 10.0117 17.2955 9.8797C17.2955 9.74769 17.2694 9.61698 17.2186 9.49512C17.1678 9.37326 17.0934 9.26266 16.9997 9.1697Z"
                                fill="#201E2E"/>
                        </svg>
                    </div>
                    <div class="dropdown_content">
                        @foreach($areas as $area)
                            @if($area != null)
                                    <?php
                                    $area_link = (new App\Models\Site)->generateAreaLink($site, $area->slug);
                                    ?>
                                <a class="footer-link"
                                   href="{{ baseUrl() }}/{{ $site->cars_areas_slug }}/{{$area_link}}">{{$area->name }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            @if($menu->link == Config::get('services.brands_link') && count($brands) >1 && $site->mono_brand_home !== 1 )
                <div class="footer_dropdown close">
                    <div class="dropdown_title">
                        <p>{{$menu->name}}</p>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.9997 9.1697C16.8123 8.98345 16.5589 8.87891 16.2947 8.87891C16.0305 8.87891 15.7771 8.98345 15.5897 9.1697L11.9997 12.7097L8.4597 9.1697C8.27234 8.98345 8.01889 8.87891 7.7547 8.87891C7.49052 8.87891 7.23707 8.98345 7.0497 9.1697C6.95598 9.26266 6.88158 9.37326 6.83081 9.49512C6.78004 9.61698 6.75391 9.74769 6.75391 9.8797C6.75391 10.0117 6.78004 10.1424 6.83081 10.2643C6.88158 10.3861 6.95598 10.4967 7.0497 10.5897L11.2897 14.8297C11.3827 14.9234 11.4933 14.9978 11.6151 15.0486C11.737 15.0994 11.8677 15.1255 11.9997 15.1255C12.1317 15.1255 12.2624 15.0994 12.3843 15.0486C12.5061 14.9978 12.6167 14.9234 12.7097 14.8297L16.9997 10.5897C17.0934 10.4967 17.1678 10.3861 17.2186 10.2643C17.2694 10.1424 17.2955 10.0117 17.2955 9.8797C17.2955 9.74769 17.2694 9.61698 17.2186 9.49512C17.1678 9.37326 17.0934 9.26266 16.9997 9.1697Z"
                                fill="#201E2E"/>
                        </svg>
                    </div>
                    <div class="dropdown_content">
                        @foreach($brands as $brand)
                            <a class="footer-link"
                               href="{{ baseUrl() }}/{{ $site->cars_brands_slug }}/{{$brand['link']}}">{{$brand['name'] }}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
        <div class="footer_prebottom_links">
            @if(count($partners)>0 )
                <div class="block partner_block">
                    <p class="block_title partner_title">{{trans('trans_renty.new.our_partner')}}</p>
                    <div class="partners_content">
                            <?php
                            $phonePattern = '/\+?[0-9]{1,4}?[-.\s]?(\(?\d{1,3}?\)?[-.\s]?)?[\d\s.-]{3,15}/';
                            ?>

                        @foreach($partners as $partner)
                                <?php $partner_logo = (new \App\Models\SitePartner)->getLogo($partner->id); ?>
                            <div>
                                @if($partner_logo)
                                    <a class="partner_logo" href="{{$partner->link}}">
                                        <img loading="lazy" src="{{$partner_logo}}" height="35" width="100%"
                                             alt="{{$partner->name ?? $site->domain}}">
                                    </a>
                                @else
                                    <a class="partner_logo" href="{{$partner->link}}"
                                       @if(preg_match($phonePattern, $partner->name)) style="direction: ltr !important;" @endif>
                                        {{$partner->name}}
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <?php if ($site->with_yachts === 1) {
                $categories = Config::get('services.site_config.categories');
                $goodfors = Config::get('services.site_config.goodfor');
                $types_yachts = Config::get('services.site_config.types_yachts');
                $marinas = Config::get('services.site_config.marinas');
            }
            ?>


            @foreach($site_menu as $menu)
                @if($menu->link == Config::get('services.types_link') && $menu->menu_page == 'types')

                    <div class="block">
                        <p class="block_title">{{$menu->name}}</p>

                        @foreach($types as $type)
                            <a class="footer-link"
                               href="{{ baseUrl() }}/{{ $site->cars_types_slug }}/{{$type['link']}}">{{$type['name'] }}</a>
                        @endforeach

                    </div>
                @endif
                @if($menu->link == Config::get('services.bodies_link'))
                    <div class="block">
                        <p class="block_title">{{$menu->name}}</p>

                            <?php $bodies = Config::get('services.site_config.bodies'); ?>
                        @foreach($bodies as $i=>$body)
                            {{--                            @if($i < 4)--}}
                            <a href="{{baseUrl().'/'.Config::get('services.bodies_link').'/'.$body['link']}}">{{$body['name']}}</a>
                            {{--                            @endif--}}
                        @endforeach

                    </div>
                @endif

            @endforeach
            @if(count($pages) > 0 && $terms['unterms'] != false)
                <div class="block">
                    <p class="block_title partner_title">{{ trans("trans_renty.car.useful_links") }}</p>
                    @foreach($pages as $page)

                        @if($page->link !== 'about-us'&&$page->add_form ==0)
                                <?php $baseUrl = false;
                                if (!checkPageForApproveAlternates($siteThemeTemplate, $page->link) && $locale != null) {
                                    $baseUrl = str_replace("/$locale", '', baseUrl());
                                } ?>
                            <a class="footer-link" href="{{ $baseUrl!=false?$baseUrl:baseUrl() }}/{{ $page->link }}"
                                {{isLinkNoFollow($page->link)?'rel=nofollow':''}}
                            >{{ $page->title }}</a>
                        @endif
                    @endforeach
                </div>
            @endif
            <div class="block">
                <p class="block_title">{{trans('trans_renty.car.company')}}</p>
                <a href="{{baseUrlHome()}}">{{trans('front.site.home')}}</a>
                @foreach($site_menu as $menu)
                    @if($menu->menu_page == 'yachts_home' && $site->with_cars === 1)
                        <a href="{{baseUrl().'/'.$menu->link}}">{{$menu->name}}</a>
                    @endif
                    @if(($menu->link == Config::get('services.catalog_link')||($menu->link == Config::get('services.blog_link')&& $currentLocal === 'en')) && $menu->footer==1)
                        <a class="" href="{{ baseUrl().'/'.$menu->link}}">{{ $menu->name }}</a>
                    @endif
                @endforeach
                @if(count($pages) > 0)
                    @foreach($pages as $page)
                        @if($page->link == 'about-us'||$page->add_form !=0)
                                <?php $baseUrl = false;
                                if (!checkPageForApproveAlternates($siteThemeTemplate, $page->link) && $locale != null) {
                                    $baseUrl = str_replace("/$locale", '', baseUrl());
                                } ?>
                            <a class=""
                               href="{{ $baseUrl!=false?$baseUrl:baseUrl() }}/{{ $page->link }}"{{isLinkNoFollow($page['link'])?'rel=nofollow':''}}>{{ $page->title }}</a>
                        @endif
                    @endforeach
                @endif
            </div>

            @if($site->multilang == 1&& checkPageForApproveAlternates($siteThemeTemplate,$path)&&checkPageForApproveAlternates($siteThemeTemplate,$path) && !Config::get('services.active_blog_pages'))
                <div class="block">
                    <p class="block_title">{{ucfirst(strtolower(trans('front.site.languages')))}}</p>

                    @foreach($available_locales as $locale_name => $available_locale)

                            <?php

                            $uri = $_SERVER['REQUEST_URI'];
                            $uri = parse_url($uri)['path'];
                            if (str_contains($uri, '/filter-catalog/') || str_ends_with($uri, '/filter-catalog')) {
                                $uri = '';
                            }
                            if ($current_locale !== Config::get("app.fallback_locale") && $available_locale == Config::get("app.fallback_locale")) {
                                if ($available_locale == Config::get("app.fallback_locale")) {
                                    if ($uri == "/$current_locale") {
                                        $uri = substr_replace($uri, "/", 0, 3);
                                    } else {
                                        $uri = substr_replace($uri, "", 0, 3);
                                    }
                                } else {
                                    $uri = substr_replace($uri, "/$available_locale", 0, 3);
                                }
                            } else {
                                if ($current_locale !== Config::get("app.fallback_locale")) {
                                    $uri = substr_replace($uri, "", 0, 3);
                                }
                                $uri = "/$available_locale" . $uri;

                            }
                            $uri = preg_replace('/(?<=.)\/$/', '', $uri);
                            $uri = $uri ? $uri : '/';
                            ?>
                        @if($available_locale !== $current_locale)
                            <a href="{{$uri}}">{{ ($available_locale!=="ae"?$locale_name:trans('langs.lang.ae')) }}</a>
                        @else
                            <span class="dropdown-item lang-link current-lng"
                                  style="opacity: 0.7;">{{ $available_locale!=="ae"?$locale_name:trans('langs.lang.ae') }}</span>
                        @endif

                    @endforeach

                </div>
            @endif
        </div>
        <div class="footer_content_bottom">
            <div class="footer_content_payment">
                <img src="/templates/smart-car-lover/img/payment/payment1.svg" alt="MasterCard" loading="lazy"/>
                <img src="/templates/smart-car-lover/img/payment/payment2.svg" alt="Visa" loading="lazy"/>
                <img src="/templates/smart-car-lover/img/payment/payment3.svg" alt="MasterCard SecureCode"
                     loading="lazy"/>
                <img src="/templates/smart-car-lover/img/payment/payment4.svg" alt="Verified by Visa" loading="lazy"/>
            </div>
            <div class="footer-bottom">
                <div class="bottom-text">{{date('Y')}} © {{ $title }}</div>
            </div>
        </div>
    </div>
</footer>

