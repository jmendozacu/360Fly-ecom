
jQuery.noConflict();
function adjustBioLeftWidth(){
    var wrap_width = jQuery('.wrapper-width').width();
    var bio_left_width = jQuery('.bio-container .bio-left .bio-left-child-x').width();
    var bio_left_element = jQuery('.bio-container .bio-left .bio-left-child-x .bio-left-child-container');
    if(wrap_width == 1000){
        var bio_left_child_container = ((450 / bio_left_width) * 100)+'%';
        bio_left_element.css('width', bio_left_child_container);
        bio_left_element.css('float', 'right');
        bio_left_element.css('margin-left', '25px');
    } else{
        bio_left_element.css('float', 'left');
        bio_left_element.css('width', '100%');
        bio_left_element.css('margin-left', 'inherit');
    }
}

jQuery(window).resize(function() {
    adjustBioLeftWidth();
});
jQuery(document).ready(function(a) {

    adjustBioLeftWidth();

    /*Community Pages DropDown toggle*/
    a( "ul li.community-first-dd" ).click(function(e) {
        a('ul li.community-first-dd ul.community-dropdown').toggle();
        e.stopPropagation();
    });

    a(document).click(function(){
        a("ul li.community-first-dd ul.community-dropdown").hide();
    });

   /*NAVIGATION MENU ANIMATION START*/
    a(".menu1").hover(
        function() {
            a(".submenu1").css("display", "inline-flex");
        },
        function() {
            a(".submenu1").css("display", "none");
        }
    );

    a(".menu1.is-shop-page-container").hover(
        function() {
            a(".submenu1.is-shop-page").css("display", "inline-flex");
        },
        function() {
            a(".submenu1.is-shop-page").css("display", "inline-flex");
        }
    );
    a(".menu2").hover(
        function() {
            a(".submenu2").css("display", "inline-flex");
            a(".submenu1.is-shop-page").css("display", "none");
        },
        function() {
            a(".submenu2").css("display", "none");
            a(".submenu1.is-shop-page").css("display", "inline-flex");
        }
    );

    /*NAVIGATION MENU ANIMATION ENDS*/
    a( ".hamburger-menu .toggle-topbar" ).click(function() {
        if(a(this).hasClass('open-hbm')){
            a('.hamburger-menu section.top-bar-section').hide();
            a(this).removeClass('open-hbm');
        } else{
            a('.hamburger-menu section.top-bar-section').show();
            a(this).addClass('open-hbm');
        }
     });
     /* Search Icon */
     var oldSearchWidth;
     a("#search").click(function(){
         oldSearchWidth = a('.search-link-header .form-group').width();
         a('.search-link-header .form-group').css('width','155px');
         a('.search-link-header .form-group').css('padding','5px 0 5px 5px');
         a('.search-link-form .form-control').css('border','1px solid #fff');
         a('.search-link-form .form-control').css('cursor','initial');
     });
     a('body').click(function(e){
         if( a(e.target).closest("#search").length > 0 ) {
             return false;
     }
         a('.search-link-header .form-group').css('width','32px');
         a('.search-link-form .form-control').css('border','none'.search-link-form .form-control').css('cursor','pointer');
     });
});
