var $j = jQuery.noConflict();
$j(document).ready(function() { 
    "use strict";
    // Append .background-image-holder <img>'s as CSS backgrounds

    $j('.background-image-holder').each(function() {
        var imgSrc = $j(this).children('img').attr('src');
        $j(this).css('background', 'url("' + imgSrc + '")');
        $j(this).children('img').hide();
        $j(this).css('background-position', 'initial');
    });

    // Fade in background images

    setTimeout(function() {
        $j('.background-image-holder').each(function() {
            $j(this).addClass('fadeIn');
        });
    }, 200);
});

