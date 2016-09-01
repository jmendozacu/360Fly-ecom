(function ($) {
    equalheight = function(container){
        var currentTallest = 0,
            currentRowStart = 0,
            rowDivs = new Array(),
            $el,
            topPosition = 0;
        $(container).each(function() {

            $el = $(this);
            $($el).height('auto')
            topPostion = $el.position().top;

            if (currentRowStart != topPostion) {
                for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                    rowDivs[currentDiv].height(currentTallest);
                }
                rowDivs.length = 0; // empty the array
                currentRowStart = topPostion;
                currentTallest = $el.height();
                rowDivs.push($el);
            } else {
                rowDivs.push($el);
                currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
            }
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
                rowDivs[currentDiv].height(currentTallest);
            }
        });
    }

    function calcBoxHeight(){
        logosHeight = $(".home-logos").outerHeight();
        windowHeight = $(window).height();

        if( $(window).width() > 1023 ){
            $(".home-hero .hero-wrapper").css('height',(windowHeight - logosHeight) + 'px')
        }
        else {
            $(".home-hero .hero-wrapper").css('height','auto')
        }
    }

    
	$(document).ready(function(){
        calcBoxHeight();
	});
    $(window).load(function() {
        if( $(window).width() > 991 ){
            equalheight('.is-blog #post-list .item');
        }
    });
	$(window).resize(function(){
        calcBoxHeight();
        if( $(window).width() > 991 ){
            equalheight('.is-blog #post-list .item');
        }
	});
})(jQuery);