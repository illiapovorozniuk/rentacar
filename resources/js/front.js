$(document).ready(function () {
    function initSlider() {
        $(".sliderCard").each(function (idx, item) {
            var carouselId = "carousel" + idx;
            this.id = carouselId;
            $(this).slick({
                dots: true,
                infinite: true,
                speed: 500,
                slidesToShow: 1,
                slidesToScroll: 1,
                variableWidth: false,
                lazyLoad: "progressive",
            });
        });

    }
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
    if ($(".sliderCard").length > 0) {
    //     if (isMobile) {
            initSlider();
        // }
    }

    if ($("#sliderBanner").length > 0) {
        $("#sliderBanner").slick({
            dots: true,
            infinite: true,
            speed: 500,
            slidesToShow: 1,
            slidesToScroll: 1,
            variableWidth: false,
            autoplay: true,
            autoplaySpeed: 6000,
        });
    }

    // FAQ
    $('.faq_block .question').click(function () {
        $(this).closest('.faq').toggleClass('active');
    });
});
