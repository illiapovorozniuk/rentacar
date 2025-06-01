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

    //HEADER
    $("header  .brand_item").each(function (idx, item) {
        //desktop

        // Use mouseenter and mouseleave for desktop
        if ($(window).width() > 768) {
            $(".brand_item").off("click").on("mouseenter", function () {
                if ($(this).closest('.pages').length > 0) {
                    $(".brand_items", this).fadeTo(10, 1).css({
                        display: $(this).find('.brand_items').hasClass('area_grid') ? 'grid' : 'flex'
                    });
                }
            }).on("mouseleave", function () {
                if ($(this).closest('.pages').length > 0) {
                    $(".brand_items", this).fadeTo(10, 1).css({
                        display: "none",
                    });
                }
            });
        } else {
            $(this).on('click', function () {
                if ($(this).hasClass('open')){
                    $(".brand_item").removeClass('open');
                } else {
                    $(".brand_item").removeClass('open');
                    $(this).addClass('open');
                }
            });
        }

        //mobile
        $(this).click(function () {
                if ($(this).closest('.mob_pages').length > 0 && $(item).find('ul').length > 0) {
                    if ($(item).hasClass('item_active')) {
                        if (event.target.classList.contains('brand_arrow') || event.target.nodeName.toLowerCase() === 'path') {
                            event.preventDefault();
                            $(item).toggleClass('item_active');
                        }
                    } else {
                        $(item).toggleClass('item_active');
                    }
                }
            }
        )
        ;
    });

    //header mobile
    $('.burger .open, .burger .close').click(function () {
        $('.burger .open').toggleClass('active');
        $('.burger .close').toggleClass('active');
        $('.header_content .pages').toggleClass('active');
    });
});
