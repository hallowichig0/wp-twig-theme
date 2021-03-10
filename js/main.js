(function($){
    /*
    * Theme Javascript
    */
    const $win = $(window);
    const $doc = $(document);

    /*
    * Functions
    */
    const triggerLoading = () => {
        $('.loader').fadeTo(400, 0);
        $('header.nav-header').fadeTo(400, 1);
        $('main.main-wrapper').fadeTo(400, 1);
        $('footer.site-footer').fadeTo(400, 1);
        $('.pre-loader').hide();
    }

    // Hide show back to top links.
    const backToTop = (el) => {
        if ($win.scrollTop() > 300) {
            $(el).fadeIn();
        } else {
            $(el).fadeOut();
        }

        $(el).once('backtotop').each(function () {
            $(this).click(function () {
                $('html, body').bind('scroll mousedown DOMMouseScroll mousewheel keyup', function () {
                    $('html, body').stop();
                });
                $('html,body').animate({scrollTop: 0}, 1200, 'easeOutQuart', function () {
                    $('html, body').unbind('scroll mousedown DOMMouseScroll mousewheel keyup');
                });
                return false;
            });
        });
    }

    /*
    * Window Resize
    */
    $win.resize(function () {

    });

    /*
    * Window Scroll
    */
    $win.scroll(function () {
        var headerHeight = $(".nav-top").outerHeight();
        
        if($(document).scrollTop() > headerHeight){
            // console.log("fixed");
            $('.nav-bottom').addClass('sticky-header');
            $('.nav-header').addClass('sticky-header-top');
        }else{
            // console.log("remove fixed");
            $('.nav-bottom').removeClass('sticky-header');
            $('.nav-header').removeClass('sticky-header-top');
        }
        
        backToTop('#back2top');
    });

    /*
    * Window onLoad
    */
    $win.on('load', () => {
        setTimeout(() => {
            triggerLoading();
        }, 1000);

        backToTop('#back2top');
    });

    /*
    * Document Ready
    */
    $doc.ready(function(){

    });

})( jQuery );