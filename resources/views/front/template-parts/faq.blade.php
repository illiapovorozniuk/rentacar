<?php  $current_locale = App::getLocale();?>
<div class="faq_block">
    <div class="faq_head">
        <h2 class="faq_title">{{trans('front.faq_title')}}</h2>
    </div>
    <div class="faqs">
        @foreach($faqs as $index => $faq)
            <div class="faq @if($index==0) active @endif">
                <div class="faq_content">
                    <div class="question">
                        @if(isset($faq_slug_replacement))
                            <h3>{{str_replace('{slug}',$faq_slug_replacement,$faq->question->$current_locale??'')}}</h3>
                        @else
                            <h3>{{$faq->question->$current_locale??''}}</h3>
                        @endif
                        <svg class="faq_arrow" width="20" height="21" viewBox="0 0 20 21" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.40831 10.5L12.3583 7.54998C12.5135 7.39384 12.6006 7.18263 12.6006 6.96248C12.6006 6.74232 12.5135 6.53111 12.3583 6.37498C12.2808 6.29687 12.1887 6.23488 12.0871 6.19257C11.9856 6.15026 11.8766 6.12848 11.7666 6.12848C11.6566 6.12848 11.5477 6.15026 11.4462 6.19257C11.3446 6.23488 11.2524 6.29687 11.175 6.37498L7.64164 9.90831C7.56353 9.98578 7.50154 10.0779 7.45923 10.1795C7.41692 10.281 7.39514 10.39 7.39514 10.5C7.39514 10.61 7.41692 10.7189 7.45923 10.8205C7.50154 10.922 7.56353 11.0142 7.64164 11.0916L11.175 14.6666C11.2528 14.7439 11.3452 14.805 11.4467 14.8465C11.5482 14.8879 11.657 14.9089 11.7666 14.9083C11.8763 14.9089 11.985 14.8879 12.0866 14.8465C12.1881 14.805 12.2804 14.7439 12.3583 14.6666C12.5135 14.5105 12.6006 14.2993 12.6006 14.0791C12.6006 13.859 12.5135 13.6478 12.3583 13.4916L9.40831 10.5Z"
                                fill="#721CAC"/>
                        </svg>
                    </div>
                    <div class="answer">
                        @if(isset($faq_slug_replacement))
                            {!!  str_replace('{slug}',$faq_slug_replacement,$faq->answer->$current_locale) !!}
                        @else
                            {!!  $faq->answer->$current_locale ?? '' !!}
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
