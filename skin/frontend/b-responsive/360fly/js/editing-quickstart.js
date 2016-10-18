// "format global";
// // "deps foundation";
// // "deps jquery";
// // "deps jquery-ui";
// // "deps app/ces_js/jquery.animate-enhanced.min";
// // "deps app/ces_js/jquery.easing.1.3";
// // "deps modernizr";
// // "deps foundation.dropdown";
// "deps app/global_header";
// // "deps app/slick-base";
// "deps app/slick.min";

//jQuery(document).foundation();

jQuery(document).ready(function(){
    jQuery('.editing-slider').on('init', function(event, slick){
                  jQuery('.editing-slider').css('display','block');
                  jQuery( ".editing-slider" ).fadeTo( "slow" , 1, function() {
                  });
    });
    jQuery('.editing-slider').slick({
        arrows: false,
        dots: false,
        fade: true,
        swipe: false,
        speed: 750,
    });

    jQuery('.editing-nav ul li').each( function( i ) {
        jQuery('.editing-nav .slide-' + i + ' a').click(function(){
            jQuery('.editing-nav li a').removeClass('active-nav');
            jQuery('.edit-custom-dots li').removeClass('custom-active');
            jQuery('.editing-slider').slick('slickGoTo',parseInt(i));
            jQuery('.editing-nav .slide-' + i + ' a').addClass('active-nav');
            jQuery('.edit-custom-dots .button-'+i).addClass('custom-active');
        });
    });

jQuery('.edit-custom-dots li').each( function( i ) {
    jQuery('.edit-custom-dots .button-'+i+' button').click(function(){
        jQuery('.editing-nav li a').removeClass('active-nav');
        jQuery('.edit-custom-dots li').removeClass('custom-active');
        jQuery('.editing-slider').slick('slickGoTo',parseInt(i));
        jQuery('.editing-nav .slide-' + i + ' a').addClass('active-nav');
        jQuery('.edit-custom-dots .button-'+i).addClass('custom-active');


    });
});

/////////////////////////////////////////////
jQuery('.effects-slider').on('init', function(event, slick){
              jQuery('.effects-slider').css('display','block');
              jQuery( ".effects-slider" ).fadeTo( "slow" , 1, function() {
              });
});

    jQuery('.effects-slider').slick({
        arrows: false,
        dots: false,
        fade: true,
        swipe: false,
        speed: 750,
    });

    jQuery('.effects-nav ul li').each( function( i ) {
        jQuery('.effects-nav .slide-' + i + ' a').click(function(){
            jQuery('.effects-nav li a').removeClass('active-nav');
            jQuery('.effects-custom-dots li').removeClass('custom-active');
            jQuery('.effects-slider').slick('slickGoTo',parseInt(i));
            jQuery('.effects-nav .slide-' + i + ' a').addClass('active-nav');
            jQuery('.effects-custom-dots .button-'+i).addClass('custom-active');

        });
    });

    jQuery('.effects-custom-dots li').each(function (i){
        jQuery('.effects-custom-dots .button-'+i+' button').click(function(){

            jQuery('.effects-nav li a').removeClass('active-nav');
            jQuery('.effects-custom-dots li').removeClass('custom-active');
            jQuery('.effects-slider').slick('slickGoTo',parseInt(i));
            jQuery('.effects-nav .slide-' + i + ' a').addClass('active-nav');
            jQuery('.effects-custom-dots .button-'+i).addClass('custom-active');
        });

    });

/////////////////////////////////////////////

jQuery('.share-slider').on('init', function(event, slick){
              jQuery('.share-slider').css('display','block');
              jQuery( ".share-slider" ).fadeTo( "slow" , 1, function() {
              });
});


    jQuery('.share-slider').slick({
        arrows: false,
        dots: false,
        fade: true,
        swipe: false,
        speed: 750,
    });

    jQuery('.share-nav ul li').each( function( i ) {
        jQuery('.share-nav .slide-' + i + ' a').click(function(){
            jQuery('.share-nav li a').removeClass('active-nav');
            jQuery('.share-custom-dots li').removeClass('custom-active');
            jQuery('.share-slider').slick('slickGoTo',parseInt(i));
            jQuery('.share-nav .slide-' + i + ' a').addClass('active-nav');
            jQuery('.share-custom-dots .button-'+i).addClass('custom-active');

        });
    });

    jQuery('.share-custom-dots li').each(function(i){
        jQuery('.share-custom-dots .button-'+i+' button').click(function(){

            jQuery('.share-nav li a').removeClass('active-nav');
            jQuery('.share-custom-dots li').removeClass('custom-active');
            jQuery('.share-slider').slick('slickGoTo',parseInt(i));
            jQuery('.share-nav .slide-' + i + ' a').addClass('active-nav');
            jQuery('.share-custom-dots .button-'+i).addClass('custom-active');

        });



    });

/////////////////////////////////////////////


});
