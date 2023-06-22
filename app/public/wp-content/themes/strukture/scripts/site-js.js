jQuery(function ($) {

    var isIE11 = !!window.MSInputMethodContext && !!document.documentMode;

    if (isIE11) {
        $('body').addClass('ie11');
    }
    /*
    |----------------------------------------------------------------
    |  Object fit fallback for ie11,
    |  Call this function with an array of selectors for image containers
    |  using Object Fit
    |----------------------------------------------------------------
    */
    if (isIE11) {
        function objectFitFallback(selectors) {
            if (!Array.isArray(selectors)) {
                selectors = selectors.split();
            }
            selectors.forEach(function (element) {
                $(element).each(function () {
                    var $container = $(this),
                        imgUrl = $container.find('img:not(.background-img)').prop('src');

                    if (imgUrl) {
                        $container
                            .css('backgroundImage', 'url(' + imgUrl + ')')
                            .addClass('compat-object-fit');
                    }
                });
            });
        }

        objectFitFallback(['.image-container', '.image-column', '.woocommerce-loop-product__link']);
    }

    /*
     |----------------------------------------------------------------
     |  Mobile Trigger
     |  (targeting all .menu-trigger, so they're syncornized )
     |----------------------------------------------------------------
     */
    $('.fs-menu-trigger').click(function (e) {
        e.preventDefault();

        $('body').toggleClass('menu-opened');
        $('.main-menu').slideToggle(250);
    });


    /*
     |----------------------------------------------------------------
     |  Mobile Sub-menu Trigger
     |----------------------------------------------------------------
     */
    $(".menu-item-has-children > a")
        .append('<span class="mobile-submenu-trigger"><i class="fa fa-caret-down" aria-hidden="true"></i></span>');

    $(".mobile-submenu-trigger").click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        $(this).toggleClass('opened');
        $(this).parent().siblings('.sub-menu').slideToggle();
    });


    /*
     |----------------------------------------------------------------
     |  Smooth Scrolling
     |  (targeting all [data-smooth-scroll])
     |----------------------------------------------------------------
     */
    $('.smooth-scroll, [data-smooth-scroll]').on('click', smoothScroll);


    /*
   |----------------------------------------------------------------
   |  Accordion
   |----------------------------------------------------------------
   */
    $(".accordion-holder").each(function () {
        var $self = $(this);

        $('body').on('click', '.accordion-label', function (e) {
            e.preventDefault();

            //Close open siblings
            $('.accordion-entry').not($(this).parent()).attr('data-status', 'closed');
            $("[data-status='closed'] .accordion-content").slideUp(250);

            //Toggle the selected section
            $(this).siblings('.accordion-content').slideToggle(250);
            $(this).parent().attr(
                'data-status',
                $(this).parent().attr('data-status') === 'opened' ? 'closed' : 'opened'
            );
        });

        $(".close", $self).click(function (e) {

            $(this).parents('.accordion-content').slideToggle(250);
            $(".accordion-entry", $self).attr('data-status', 'closed');
        });
    });

    /*
    |----------------------------------------------------------------
    |  Tabs
    |----------------------------------------------------------------
    */

    function openTab(evt, tabId) {
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tab-content");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tab-link");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabId).style.display = "block";
        evt.currentTarget.className += " active";
    }

    /*
    |----------------------------------------------------------------
    |  Loop slideout
    |----------------------------------------------------------------
    */

    function resetSlideout() {
        $('.loop-hidden').slideUp(250);
        $('.loop-content').removeClass('show-slideout');
        $('.minus').removeClass('show-icon');
        $('.plus').removeClass('hide-icon');
    };

    $('.slideout-item .container .loop-content').on('click', function () {

        var parent = $(this).parent().parent();

        if ($(this).hasClass('show-slideout')) {
            resetSlideout();
        } else {
            resetSlideout();
            parent.find('.loop-hidden').slideDown(250);
            parent.find('.loop-content').addClass('show-slideout');
            parent.find('.plus').addClass('hide-icon');
            parent.find('.minus').addClass('show-icon')
        }

    });

    $('.close').on('click', function () {
        resetSlideout();
    });

    // add class for showing hover image if image exists
    $('.slideout-item').find('.hover-image').parent().parent().addClass('has-hover');


    /*
|----------------------------------------------------------------
|  Testimonial slider
|----------------------------------------------------------------
*/

    $('.testimonial-slider').slick({
        autoplay: true,
        infinite: true,
        dots: false,
        arrows: true,
        fade: false,
        swipe: true,
        prevArrow: '<i class="fa fa-angle-left prevArrow" aria-hidden="true"></i>',
        nextArrow: '<i class="fa fa-angle-right nextArrow" aria-hidden="true"></i>',
        autoplaySpeed: 5000,
    });


    /*
     |----------------------------------------------------------------
     |  Gallery Slider
     |----------------------------------------------------------------
     */
    $('.single-item').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="slick-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>'
    });

    $('.gallery-wrapper').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: false,
        draggable: true,
        swipe: true,
        arrows: false,
        adaptiveHeight: true,
        lazyLoad: 'progressive',

        fade: true,
        asNavFor: '.slick-thumbnail-grid'

    });

    $('.slick-thumbnail-grid').slick({
        asNavFor: '.slick',
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        lazyLoad: 'progressive',
        dots: false,
        arrows: true,
        prevArrow: '<div class="slick-prev"><i class="fa fa-chevron-circle-left" aria-hidden="true"></i></div>',
        nextArrow: '<div class="slick-next"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i></div>',
        centerMode: false,
        focusOnSelect: true,

    });

    /*
    |----------------------------------------------------------------
    | Counter
    |----------------------------------------------------------------
    */

    $.fn.isInViewport = function () {
        var element = $(this);
        if (element.length) {
            var elementTop = $(this).offset().top;
            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();
            return elementTop > viewportTop && elementTop < viewportBottom;
        }
    };

    $(window).on('resize scroll load', function () {
        if ($('.statistic').isInViewport()) {
            $('.stat').each(function () {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({countNum: $this.text()}).animate({
                        countNum: countTo
                    },
                    {
                        duration: 1500,
                        easing: 'linear',
                        step: function () {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function () {
                            $this.text(this.countNum);
                        }

                    });
            });
            $(window).off('scroll');
        }
    });

    /*
      |----------------------------------------------------------------
      |  Search form Error Handling
      |----------------------------------------------------------------
      */

    $('form[method="get"]').submit(function () {
        console.log('hi');
        $(this).find(':input').each(function () {
            var inp = $(this);
            if (!inp.val()) {
                inp.remove();
            }
        });
    });

    /*
      |----------------------------------------------------------------
      |  Simple submit
      |----------------------------------------------------------------
      */
    $('#simple-filter select').on('change', function () {
        this.form.submit();
    });


    /*
      |----------------------------------------------------------------
      |  Smooth Scroll
      |----------------------------------------------------------------
      */

    function smoothScroll(e) {
        var $target = $($(this).attr('data-smooth-scroll'));

        if (!$target.size()) {
            var href = $(this).attr('href').split("#");
            $target = $('#' + href[href.length - 1]);
        }

        if ($target.size()) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: $target.offset().top - 50
            }, 250);
        }
    }

    function configureMenus() {
        if (window.innerWidth <= 767) {
            //combine menus
            $('ul.utility-menu > li').addClass('moved-item');
            $('ul.utility-menu > li').appendTo('ul.main-menu');

        }

        if (window.innerWidth > 767) {
            //split menus
            $('ul.main-menu > li.moved-item').appendTo('ul.utility-menu');
            $('ul.main-menu').remove('ul.main-menu > li.moved-item');
        }
    }

    /*
    |----------------------------------------------------------------
    |  Filter form Error Handling
    |----------------------------------------------------------------
    */

    $('form[method="get"]').submit(function () {
        $(this).find(':input').each(function () {
            var inp = $(this);
            if (!inp.val()) {
                inp.remove();
            }
        });
    });

    $('.taxonomy-select').on('change', function () {
        var taxSelects = $('.search-form').find('.taxonomy-select');
        taxSelects = Array.from(taxSelects);
        var formHasValue = taxSelects.reduce(function (acc, curr) {
            return !!curr.options[curr.selectedIndex].value || acc;
        }, false);

        if (formHasValue) {
            $('#filter-submit-button').removeAttr('disabled');
        } else {
            $('#filter-submit-button').addAttr('disabled');
        }
    });

    $('#search-input').on('change input', function (e) {
        if ($(this).val()) {
            $('#filter-submit-button').removeAttr('disabled');
        } else if (!$(this.val())) {
            $('#filter-submit-button').addAttr('disabled');
        }
    });


    // dynamically set the height of image container based on an absolute positioned elements height
    function setCtaHeight() {
        var parent = $('.right-floating-content-full-width');
        var contentHeight = parent.find('.content-container').outerHeight();
        var image = parent.find('.image-column');

        if (window.innerWidth > 979) {
            image.css({
                height: contentHeight + 200 + "px",
            });
        } else {
            image.css({
                height: 'auto',
            });
        }
    }

    /*
    |----------------------------------------------------------------
    | Window resize event handler with initial function calls
    |----------------------------------------------------------------
    */
    setCtaHeight();
    configureMenus();

    var delay = 250,
        throttled = false;

    $(window).on('resize', function () {
        if (!throttled) {
            setCtaHeight();
            configureMenus();
            throttled = true;
            // set a timeout to un-throttle
            setTimeout(function () {
                throttled = false;
            }, delay);
        }

    });



});