var $jQ = jQuery.noConflict();
$jQ(document).ready(function($) {
	
   /*NAVIGATION MENU ANIMATION START*/
    $(".menu1").hover(
        function() {
            $(".submenu1").css("display", "inline-flex");
        },
        function() {
            $(".submenu1").css("display", "none");
        }
    );

    $(".menu2").hover(
        function() {
            $(".submenu2").css("display", "inline-flex");
        },
        function() {
            $(".submenu2").css("display", "none");
        }
    );
    /*NAVIGATION MENU ANIMATION ENDS*/

});