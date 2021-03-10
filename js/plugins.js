(function($){
    /*
     *   All global plugins here
     */

    // Nice Scroll
    $.fn.nice_scroll = function(options) {

        var $this = $(this); // selector

        var settings = $.extend({
            // These are the defaults.
            enable: true,
            timeout: 0, // set delay before nice scroll appear
        }, options );
    
        setTimeout(function(){
            if(settings.enable === true) {
                $this.niceScroll({
                    emulatetouch: true,
                    preventmultitouchscrolling: false,
                    autohidemode: false,
                    grabcursorenabled: false,
                    scrollbarid: true,
                    zindex: '99999',
                }).resize();
            }else {
                $this.niceScroll().remove();
            }
        }, settings.timeout);
    };

    // Slick Slider
    $.fn.slick_slider = function(options) {

        var $this = $(this); // selector

        var settings = $.extend({
            // These are the defaults.
            autoplay: false,
            autoplaySpeed: 8000,
            lightbox: false,
            lightboxOverlay: 'rgba(0, 0, 0, 0.6)',
            lightboxCloseBackground: '#000000',
        }, options );

        $this.slick({
            dots: true,
            arrows: true,
            infinite: true,
            autoplay: settings.autoplay,
            autoplaySpeed: settings.autoplaySpeed,
            speed: 1000,
            slidesPerRow: 1,
            rows: 1,
            adaptiveHeight: false,
            useTransform: false,
            pauseOnHover:false,
            pauseOnFocus: false,
            pauseOnDotsHover: false,
            fade: true,
            // lazyLoad: 'ondemand',
            accessibility: false
        }).on('init', function(event, slick, currentSlide, nextSlide){
            // for infinite scroll - autoplay after re initialize slick
            $(this).each(function(){
                var tis = $(this);
                tis.slick('slickPlay');
            });
        }).on('afterChange', function(event, slick, currentSlide, nextSlide){
            $(this).each(function(){
                var current_slick = $(this).find('.slick-active');
                var slick_img = $(this).find('.slick-active .slick-image');
                var slick_img_clone = $(this).find('.slick-cloned .slick-image');
                var tis = $(this);

                // add lazyload class for each slick active
                if(!slick_img.hasClass('lazyloaded')){
                    slick_img.addClass('lazyload');
                }

                // cloned add lazyload class
                if(!slick_img_clone.hasClass('lazyloaded')){
                    slick_img_clone.addClass('lazyload');
                }

                if(slick_img.hasClass('lazyloaded')){
                    tis.slick('slickPlay');
                }else{
                    tis.slick('slickPause');
                }
                
                slick_img.on('lazyloaded', function(){
                    // current_slick.removeClass('lazyloading');
                    current_slick.removeClass('slick-hide');
                    // $('.slick-carousel').slick('slickPlay');
                    if(this.complete){
                        tis.slick('slickPlay');
                        slick_img.addClass('completed');
                    }else{
                        tis.slick('slickPause');
                    }
                });
            });
        });

        // Off autoplay on initial load. On autoplay after image has been lazyloaded.
        $this.each(function(){
            var tis = $(this);
            var current_slick = $(this).find('.slick-active');
            var slick_img = $(this).find('.slick-active .slick-image');

            slick_img.addClass('lazyload');
        
            slick_img.on('lazyloaded', function(){
                slick_img.addClass('completed');
                current_slick.removeClass('slick-hide');
                tis.slick('slickPlay');
            });

            // enable lightbox (make sure you put slick-lightbox class to your <a> tag)
            if(settings.lightbox === true) {
                var venoOptions = {
                    // Options
                    pinner:    'cube-grid',
                    overlayColor: settings.lightboxOverlay,
                    closeBackground: settings.lightboxCloseBackground,
                    framewidth: 'auto',
                    frameheight: 'auto',
        
                    // Callback
                    // is called before the venobox pops up, return false to prevent opening;
                    cb_pre_open : function(obj){
                        tis.slick('slickPause');
                    },
                    // is called before closing, return false to prevent closing
                    cb_pre_close : function(obj, gallIndex, thenext, theprev){
                        tis.slick('slickPlay');
                    },
                };
                var lightbox_selector = tis.find('.slick-lightbox');
                lightbox_selector.venobox(venoOptions);
            }
        });
    };
})( jQuery );
