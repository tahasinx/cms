/*
 *
 *		CUSTOM.JS
 *
 */

// WAVES EFFECT //
!function(t){"use strict";function e(t){return null!==t&&t===t.window}function n(t){return e(t)?t:9===t.nodeType&&t.defaultView}function a(t){var e,a,i={top:0,left:0},o=t&&t.ownerDocument;return e=o.documentElement,void 0!==t.getBoundingClientRect&&(i=t.getBoundingClientRect()),a=n(o),{top:i.top+a.pageYOffset-e.clientTop,left:i.left+a.pageXOffset-e.clientLeft}}function i(t){var e="";for(var n in t)t.hasOwnProperty(n)&&(e+=n+":"+t[n]+";");return e}function o(t){if(!1===d.allowEvent(t))return null;for(var e=null,n=t.target||t.srcElement;null!==n.parentElement;){if(!(n instanceof SVGElement||-1===n.className.indexOf("waves"))){e=n;break}if(n.classList.contains("waves")){e=n;break}n=n.parentElement}return e}function r(e){var n=o(e);null!==n&&(c.show(e,n),"ontouchstart"in t&&(n.addEventListener("touchend",c.hide,!1),n.addEventListener("touchcancel",c.hide,!1)),n.addEventListener("mouseup",c.hide,!1),n.addEventListener("mouseleave",c.hide,!1))}var s=s||{},u=document.querySelectorAll.bind(document),c={duration:750,show:function(t,e){if(2===t.waves)return!1;var n=e||this,o=document.createElement("div");o.className="waves-ripple",n.appendChild(o);var r=a(n),s=t.pageY-r.top,u=t.pageX-r.left,d="scale("+n.clientWidth/100*15+")";"touches"in t&&(s=t.touches[0].pageY-r.top,u=t.touches[0].pageX-r.left),o.setAttribute("data-hold",Date.now()),o.setAttribute("data-scale",d),o.setAttribute("data-x",u),o.setAttribute("data-y",s);var l={top:s+"px",left:u+"px"};o.className=o.className+" waves-notransition",o.setAttribute("style",i(l)),o.className=o.className.replace("waves-notransition",""),l["-webkit-transform"]=d,l["-moz-transform"]=d,l["-ms-transform"]=d,l["-o-transform"]=d,l.transform=d,l.opacity="1",l["-webkit-transition-duration"]=c.duration+"ms",l["-moz-transition-duration"]=c.duration+"ms",l["-o-transition-duration"]=c.duration+"ms",l["transition-duration"]=c.duration+"ms",l["-webkit-transition-timing-function"]="cubic-bezier(0.250, 0.460, 0.450, 0.940)",l["-moz-transition-timing-function"]="cubic-bezier(0.250, 0.460, 0.450, 0.940)",l["-o-transition-timing-function"]="cubic-bezier(0.250, 0.460, 0.450, 0.940)",l["transition-timing-function"]="cubic-bezier(0.250, 0.460, 0.450, 0.940)",o.setAttribute("style",i(l))},hide:function(t){d.touchup(t);var e=this,n=(e.clientWidth,null),a=e.getElementsByClassName("waves-ripple");if(!(a.length>0))return!1;var o=(n=a[a.length-1]).getAttribute("data-x"),r=n.getAttribute("data-y"),s=n.getAttribute("data-scale"),u=350-(Date.now()-Number(n.getAttribute("data-hold")));u<0&&(u=0),setTimeout(function(){var t={top:r+"px",left:o+"px",opacity:"0","-webkit-transition-duration":c.duration+"ms","-moz-transition-duration":c.duration+"ms","-o-transition-duration":c.duration+"ms","transition-duration":c.duration+"ms","-webkit-transform":s,"-moz-transform":s,"-ms-transform":s,"-o-transform":s,transform:s};n.setAttribute("style",i(t)),setTimeout(function(){try{e.removeChild(n)}catch(t){return!1}},c.duration)},u)},wrapInput:function(t){for(var e=0;e<t.length;e++){var n=t[e];if("input"===n.tagName.toLowerCase()){var a=n.parentNode;if("i"===a.tagName.toLowerCase()&&-1!==a.className.indexOf("waves"))continue;var i=document.createElement("i");i.className=n.className+" waves-input-wrapper";var o=n.getAttribute("style");o||(o=""),i.setAttribute("style",o),n.className="waves-waves-input",n.removeAttribute("style"),a.replaceChild(i,n),i.appendChild(n)}}}},d={touches:0,allowEvent:function(t){var e=!0;return"touchstart"===t.type?d.touches+=1:"touchend"===t.type||"touchcancel"===t.type?setTimeout(function(){d.touches>0&&(d.touches-=1)},500):"mousedown"===t.type&&d.touches>0&&(e=!1),e},touchup:function(t){d.allowEvent(t)}};s.displayEffect=function(e){"duration"in(e=e||{})&&(c.duration=e.duration),c.wrapInput(u(".waves")),"ontouchstart"in t&&document.body.addEventListener("touchstart",r,!1),document.body.addEventListener("mousedown",r,!1)},s.attach=function(e){"input"===e.tagName.toLowerCase()&&(c.wrapInput([e]),e=e.parentElement),"ontouchstart"in t&&e.addEventListener("touchstart",r,!1),e.addEventListener("mousedown",r,!1)},t.Waves=s,document.addEventListener("DOMContentLoaded",function(){s.displayEffect()},!1)}(window);

(function($){

    "use strict";

    // DETECT TOUCH DEVICE //
    function is_touch_device() {
        return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
    }


    // SHOW/HIDE MOBILE MENU //
    function show_hide_mobile_menu() {

        $(".mobile-menu-button").on("click", function(e) {

            e.preventDefault();
            e.stopPropagation();

            $("#mobile-menu").toggleClass("open");
            $('body').toggleClass("body-overlay");

        });

        $("body").on("click", function() {
            if ($("#mobile-menu").hasClass("open")) {
                $("#mobile-menu").removeClass("open");
                $('body').removeClass("body-overlay");
            }
        });

    }



    // MOBILE MENU //
    function mobile_menu() {

        if ($(window).width() < 992) {

            if ($("#menu").length < 1) {

                $("#header").append('<ul id="menu" class="menu-2">');

                $("#menu-left").clone().children().appendTo($("#menu"));
                $("#menu-right").clone().children().appendTo($("#menu"));

            }

            if ($("#menu").length > 0) {

                if ($("#mobile-menu").length < 1) {

                    $("#menu").clone().attr({
                        id: "mobile-menu",
                        class: ""
                    }).insertAfter("#header");

                    $("#mobile-menu > li > a").addClass("waves");

                    $("#mobile-menu li").each(function() {

                        if ($(this).hasClass('dropdown') || $(this).hasClass('megamenu')) {
                            $(this).append('<span class="arrow"></span>');
                        }

                    });

                    $("#mobile-menu .megamenu .arrow").on("click", function(e) {

                        e.preventDefault();
                        e.stopPropagation();

                        $(this).toggleClass("open").prev("div").slideToggle(300);

                    });

                    $("#mobile-menu .dropdown .arrow").on("click", function(e) {

                        e.preventDefault();
                        e.stopPropagation();

                        $(this).toggleClass("open").prev("ul").slideToggle(300);

                    });

                }

            }

        } else {

            $("#mobile-menu").removeClass("open");
            $(".menu-2").hide();
            $('body').removeClass("body-overlay");

        }

    }


    // STICKY //
    function sticky() {

        var sticky_point = 155,
            smartmed_colors = $.cookie('smartmed_colors');

        $("#header").clone().attr({
            id: "header-sticky",
            class: ""
        }).insertAfter("header");

        $("#header-sticky #logo img").attr("src", "assets/css/alternative-styles/logos/logo-" + smartmed_colors + ".png");

        $(window).scroll(function(){

            if ($(window).scrollTop() > sticky_point) {
                $("#header-sticky").slideDown(300).addClass("header-sticky");
            } else {
                $("#header-sticky").slideUp(100).removeClass("header-sticky");
            }

        });

    }


    // PROGRESS BARS //
    function progress_bars() {

        $(".progress .progress-bar:in-viewport").each(function() {

            if (!$(this).hasClass("animated")) {
                $(this).addClass("animated");
                $(this).animate({
                    width: $(this).attr("data-width") + "%"
                }, 2000);
            }

        });

    }


    // CHARTS //
    function pie_chart() {

        if (typeof $.fn.easyPieChart !== 'undefined') {

            $(".pie-chart:in-viewport").each(function() {

                $(this).easyPieChart({
                    animate: 1500,
                    lineCap: "square",
                    lineWidth: $(this).attr("data-line-width"),
                    size: $(this).attr("data-size"),
                    barColor: $(this).attr("data-bar-color"),
                    trackColor: $(this).attr("data-track-color"),
                    scaleColor: "transparent",
                    onStep: function(from, to, percent) {
                        $(this.el).find(".pie-chart-percent .value").text(Math.round(percent));
                    }
                });

            });

        }

    }

    // COUNTER //
    function counter() {

        if (typeof $.fn.jQuerySimpleCounter !== 'undefined') {

            $(".counter .counter-value:in-viewport").each(function() {

                if (!$(this).hasClass("animated")) {
                    $(this).addClass("animated");
                    $(this).jQuerySimpleCounter({
                        start: 0,
                        end: $(this).attr("data-value"),
                        duration: 2000
                    });
                }

            });

        }
    }


    // LOAD MORE PROJECTS //
    function load_more_projects() {

        var number_clicks = 0;

        $(".load-more").on("click", function(e) {

            e.preventDefault();

            if (number_clicks == 0) {
                $.ajax({
                    type: "POST",
                    url: $(".load-more").attr("href"),
                    dataType: "html",
                    cache: false,
                    msg : '',
                    success: function(msg) {
                        $(".isotope").append(msg);
                        $(".isotope").imagesLoaded(function() {
                            $(".isotope").isotope("reloadItems").isotope();
                            $(".fancybox").fancybox({
                                prevEffect: 'none',
                                nextEffect: 'none',
                                padding: 0
                            });
                        });
                        number_clicks++;
                        $(".load-more").html("Nothing to load");
                    }
                });
            }

        });

    }


    // SHOW/HIDE SCROLL UP //
    function show_hide_scroll_top() {

        if ($(window).scrollTop() > $(window).height()/2) {
            $("#scroll-up").fadeIn(300);
        } else {
            $("#scroll-up").fadeOut(300);
        }

    }


    // SCROLL UP //
    function scroll_up() {

        $("#scroll-up").on("click", function() {
            $("html, body").animate({
                scrollTop: 0
            }, 800);
            return false;
        });

    }


    // INSTAGRAM FEED //
    function instagram_feed() {

        if ((typeof Instafeed !== 'undefined') & ($("#instafeed").length > 0)) {

            var nr = $("#instafeed").data('number');
            var userid = $("#instafeed").data('user');
            var accesstoken = $("#instafeed").data('accesstoken');

            var feed = new Instafeed({
                target: 'instafeed',
                get: 'user',
                userId: userid,
                accessToken: accesstoken,
                limit: nr,
                resolution: 'thumbnail',
                sortBy: 'most-recent'
            });

            feed.run();

        }

    }


    // ANIMATIONS //
    function animations() {

        if (typeof WOW !== 'undefined') {

            animations = new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 100,
                mobile: false,
                live: true
            });

            animations.init();

        }

    }


    // FOOTER PARALLAX //
    function footer_parallax() {

        if ($(window).width() > 767 ) {
            $("#main-container").css("margin-bottom", $("#footer-container").height());
        }

    }

    // DOCUMENT READY //
    $(document).ready(function(){

        $('html,body').animate({
            scrollTop: $(window).scrollTop() + 1
        }, 1000);

        // STICKY //
        if ($("body").hasClass("sticky-header")) {
            sticky();
        }


        // MENU //
        if (typeof $.fn.superfish !== 'undefined') {

            $(".menu").superfish({
                delay: 500,
                animation: {
                    opacity: 'show',
                    height: 'show'
                },
                speed: 'fast',
                autoArrows: true
            });

        }


        // SHOW/HIDE MOBILE MENU //
        show_hide_mobile_menu();


        // MOBILE MENU //
        mobile_menu();


        // FANCYBOX //
        if (typeof $.fn.fancybox !== 'undefined') {

            $(".fancybox").fancybox({
                prevEffect: 'none',
                nextEffect: 'none',
                padding: 0
            });

        }


        // OWL Carousel //
        if (typeof $.fn.owlCarousel !== 'undefined') {

            /* MAIN SLIDER */
            var main_slider = $(".owl-carousel.main-slider");

            main_slider.on('initialize.owl.carousel', function(event) {
                window.setTimeout(function() {
                    $(".main-slider .slide-description").addClass("animated");
                }, 700);
            });

            main_slider.owlCarousel({
                items: 1,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 1200,
                loop: true,
                nav: true,
                navText: false,
                dots: true,
                mouseDrag: false,
                touchDrag: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut'
            });

            main_slider.on('translate.owl.carousel', function(event) {
                $(".main-slider .slide-description").delay(200).removeClass("animated");
            });

            main_slider.on('translated.owl.carousel', function(event) {
                $(".main-slider .slide-description").addClass("animated");
            });

            // TESTIMONIALS SLIDER //
            $(".owl-carousel.testimonials-slider").owlCarousel({
                items: 1,
                autoplay: true,
                autoplayTimeout: 4000,
                autoplayHoverPause: true,
                smartSpeed: 300,
                loop: true,
                nav: false,
                navText: false,
                dots: true,
                mouseDrag: true,
                touchDrag: true
            });

            $(".owl-carousel.testimonials-carousel").owlCarousel({
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 1200,
                loop: true,
                nav: true,
                navText: false,
                dots: false,
                mouseDrag: true,
                touchDrag: true,
                center: true,
                responsive: {
                    0:{
                        items: 1
                    },
                    768:{
                        items: 3
                    },
                }
            });

            // CLIENTS SLIDER //
            $(".owl-carousel.clients-slider").owlCarousel({
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                smartSpeed: 1200,
                loop: true,
                nav: true,
                navText: false,
                dots: true,
                mouseDrag: true,
                touchDrag: true,
                responsive: {
                    0:{
                        items: 1
                    },
                    480:{
                        items: 2
                    },
                    768:{
                        items: 3
                    },
                    992:{
                        items: 4
                    },
                    1200:{
                        items: 5
                    }
                }
            });

        }


        // GOOGLE MAPS //
        if (typeof $.fn.gmap3 !== 'undefined') {

            $(".map").each(function() {

                var data_zoom = 15,
                    data_height,
                    data_popup = false;

                if ($(this).attr("data-zoom") !== undefined) {
                    data_zoom = parseInt($(this).attr("data-zoom"),10);
                }

                if ($(this).attr("data-height") !== undefined) {
                    data_height = parseInt($(this).attr("data-height"),10);
                }

                if ($(this).attr("data-address-details") !== undefined) {

                    data_popup = true;

                    var infowindow = new google.maps.InfoWindow({
                        content: $(this).attr("data-address-details")
                    });

                }


                $(this)
                    .gmap3({
                        address: $(this).attr("data-address"),
                        zoom: data_zoom,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        scrollwheel: false
                    })
                    .marker([
                        {address: $(this).attr("data-address")}
                    ])
                    .on({
                        click: function(marker, event){
                            if (data_popup) {
                                infowindow.open(marker.get('map'), marker);
                            }
                        }
                    });

                $(this).css("height", data_height + "px");

            });

        }


        // ISOTOPE //
        if ((typeof $.fn.imagesLoaded !== 'undefined') && (typeof $.fn.isotope !== 'undefined')) {

            $(".isotope").imagesLoaded( function() {

                var container = $(".isotope");

                container.isotope({
                    itemSelector: '.isotope-item',
                    layoutMode: 'masonry',
                    transitionDuration: '0.8s'
                });

                $(".filter li a").on("click", function() {
                    $(".filter li a").removeClass("active");
                    $(this).addClass("active");

                    var selector = $(this).attr("data-filter");
                    container.isotope({
                        filter: selector
                    });

                    return false;
                });

                $(window).resize(function() {
                    container.isotope();
                });

            });

        }


        // LOAD MORE PORTFOLIO ITEMS //
        load_more_projects();


        // CONTACT FORM VALIDATE & SUBMIT //
        // VALIDATE //
        if (typeof $.fn.validate !== 'undefined') {

            $("#contact-form").validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    subject: {
                        required: true
                    },
                    message: {
                        required: true,
                        minlength: 3
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name!"
                    },
                    email: {
                        required: "Please enter your email!",
                        email: "Please enter a valid email address"
                    },
                    subject: {
                        required: "Please enter the subject!"
                    },
                    message: {
                        required: "Please enter your message!"
                    }
                },

                // SUBMIT //
                submitHandler: function(form) {
                    var result;
                    $(form).ajaxSubmit({
                        type: "POST",
                        data: $(form).serialize(),
                        url: "assets/php/send.php",
                        success: function(msg) {

                            if (msg == 'OK') {
                                result = '<div class="alert alert-success">Your message was successfully sent!</div>';
                                $("#contact-form").clearForm();
                            } else {
                                result = msg;
                            }

                            $("#alert-area").html(result);

                        },
                        error: function() {

                            result = '<div class="alert alert-danger">There was an error sending the message!</div>';
                            $("#alert-area").html(result);

                        }
                    });
                }
            });

        }


        // PARALLAX //
        if (typeof $.fn.stellar !== 'undefined') {

            if (!is_touch_device()) {

                $(window).stellar({
                    horizontalScrolling: false,
                    verticalScrolling: true,
                    responsive: true
                });

            } else {

                $(".parallax").addClass("parallax-disable");

            }

        }


        // SHOW/HIDE SCROLL UP
        show_hide_scroll_top();


        // SCROLL UP //
        scroll_up();


        // PROGRESS BARS //
        progress_bars();


        // PIE CHARTS //
        pie_chart();


        // COUNTER //
        counter();


        // YOUTUBE PLAYER //
        if (typeof $.fn.mb_YTPlayer !== 'undefined') {

            $(".youtube-player").mb_YTPlayer();

        }


        // INSTAGRAM FEED //
        instagram_feed();


        // TWITTER //
        if(typeof twitterFetcher !== 'undefined' && ($('.widget-twitter').length > 0)) {

            $('.widget-twitter').each(function(index){

                var account_id = $('.tweets-list', this).attr('data-account-id'),
                    items = $('.tweets-list', this).attr('data-items'),
                    newID = 'tweets-list-' + index;

                $('.tweets-list', this).attr('id', newID);

                var config = {
                    "id": account_id,
                    "domId": newID,
                    "maxTweets": items,
                    "showRetweet": false,
                    "showTime": false,
                    "showUser": false,
                    "showInteraction": false
                };

                twitterFetcher.fetch(config);
            });

        }


        // COUNTDOWN //
        if (typeof $.fn.countdown !== 'undefined') {

            $(".countdown").countdown('2017/12/31 00:00', function(event) {
                $(this).html(event.strftime(
                    '<div><div class="count">%-D</div> <span>Days</span></div>' +
                    '<div><div class="count">%-H</div> <span>Hours</span></div>' +
                    '<div><div class="count">%-M</div> <span>Minutes</span></div>' +
                    '<div><div class="count">%S</div> <span>Seconds</span></div>'
                ));
            });

        }


        // ANIMATIONS //
        animations();


        // FOOTER PARALLAX //
        if ($("body").hasClass("footer-parallax")) {
            footer_parallax();
        }

    });


    // WINDOW SCROLL //
    $(window).scroll(function() {

        progress_bars();
        pie_chart();
        counter();
        show_hide_scroll_top();

    });


    // WINDOW RESIZE //
    $(window).resize(function() {

        mobile_menu();

        if ($("body").hasClass("footer-parallax")) {
            footer_parallax();
        }

    });

})(window.jQuery);