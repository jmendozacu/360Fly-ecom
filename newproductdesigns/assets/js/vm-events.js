(function ($) {

    $(".flexslider").css("opacity", 1);

    // Mobile DOM Manipulation
    if ($(window).width() < 767){
        $(".z-m-slider .keyPoints").each(function( index ) {
            cHTML = $(this).html();
            $(".z-m-slider ul.mobile").append(cHTML);
        });
        $(".z-m-slider ul.mobile div").each(function( index ) {
            cHTML = $(this).html();
            $(".z-m-slider ul.mobile").append("<li>" + cHTML + "</li>");
            $(this).remove();
        });
    }


    // Desktop and Mobile Tabs
    $(".z-tab-links a, a.z-mtab").click(function() {
        if ($(this).hasClass("active")){
            console.log("slide up");
            $(".z-tab-links a, a.z-mtab").removeClass("active");
            $("#tab-testimonials, #tab-tech-specs, #tab-apps").slideUp();
            // Destroy Mobile Slider
            $('.z-m-slider').flexslider("destroy");

        } else{
            $(".z-tab-links a, a.z-mtab").removeClass("active");
            $(this).addClass("active");
            tabT = $(this).attr("href").substring(1);

            // Tab Gradients
            if ($(window).width() > 767){
                if (tabT == "testimonials") {
                    $('.z-techLink').addClass("z-gradR");
                    $('.z-appsLink').addClass("z-gradR");
                    $(this).removeClass('z-gradL');
                }
                if (tabT == "tech-specs") {
                    $('.z-testLink').addClass("z-gradL");
                    $('.z-appsLink').addClass('z-gradR');
                    $(this).removeClass('z-gradR');
                    $(this).removeClass('z-gradL');
                }
                if (tabT == "apps") {
                    $('.z-testLink').addClass("z-gradL");
                    $('.z-techLink').removeClass("z-gradR");
                    $('.z-techLink').addClass("z-gradL");
                    $(this).removeClass('z-gradR');
                }

            }

            $("#tab-testimonials, #tab-tech-specs, #tab-apps").slideUp();
            $("#tab-" + tabT).slideDown();
            // Initiate Mobile Sider
            if (tabT == "tech-specs"){
                if ($(window).width() < 767){
                    $('.z-m-slider').flexslider({
                        animation: "slide", itemMargin: 0, easing: "swing", touch: "true", slideshow: "false", directionNav: true
                    });
                }
            }
        }
        return false;
    });


    // Compatible Accessories
    $(".z-access").click(function() {
        $('html,body').animate({
          scrollTop:  $(".z-featured").offset().top
        }, 1000);
        return false;
    });


    // Video THumb
    $(".z-video-play").click(function() {
        $('html,body').animate({
          scrollTop:  $(".z-videos").offset().top
        }, 1000);
        var myPlayer = videojs("video_4k");
        myPlayer.play();
        return false;
    });

    // Banner Events
    $(".z-b-close").click(function() {
        $(".z-banner").slideUp();
        createCookie("popupAlreadyShown", 1, 1);
        return false;
    });


    // var isCookie = readCookie("popupAlreadyShown");
    // if (!isCookie) {
    //     $(".z-banner").slideDown();
    //     $(".z-b-close").click(function() {
    //         $(".z-banner").slideUp();
    //         createCookie("popupAlreadyShown", 1, 1);
    //         return false;
    //     });
    // }

    function createCookie(name, value, days) {
       if (days) {
           var date = new Date();
           date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
           var expires = "; expires=" + date.toGMTString();
       } else var expires = "";
       document.cookie = name + "=" + value + expires + "; path=/";
    }

    function readCookie(name) {
       var nameEQ = name + "=";
       var ca = document.cookie.split(';');
       for (var i = 0; i < ca.length; i++) {
           var c = ca[i];
           while (c.charAt(0) == ' ') c = c.substring(1, c.length);
           if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
       }
       return null;
    }

    function eraseCookie(name) {
       createCookie(name, "", -1);
    }



})(jQuery);
