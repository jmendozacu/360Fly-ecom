jQuery(document).ready(function(a) {
	
   /*NAVIGATION MENU ANIMATION START*/
    a(".menu1").hover(
        function() {
            a(".submenu1").css("display", "inline-flex");
        },
        function() {
            a(".submenu1").css("display", "none");
        }
    );

    a(".menu2").hover(
        function() {
            a(".submenu2").css("display", "inline-flex");
        },
        function() {
            a(".submenu2").css("display", "none");
        }
    );
    /*NAVIGATION MENU ANIMATION ENDS*/

});