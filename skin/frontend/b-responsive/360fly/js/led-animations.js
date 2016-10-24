"format global";
"deps foundation";
"deps jquery";
"deps jquery-ui";
"deps modernizr";
"deps foundation.dropdown";
"deps app/mobile-menu";

//jQuery(document).foundation();

jQuery( document ).ready(function() {

  var triNum = 0;
  var triID = "AnimateTriangle";
  var clicked = 0;

  function initializeSVG(e) {
    jQuery('#'+triID).remove();
    jQuery('.triangle').remove();
    jQuery( ".led-camera" ).append( "<svg id='"+triID+"' class='triangle' version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 21.3 54.2' xml:space='preserve'><polyline class='st0' points='21.3,16 0,0 0,54.2'/></svg>" );
  };

  jQuery("a").click(function(e) {
      initializeSVG(e);
      //console.log("This is triID at start "+triID);
      clicked = 1;
      clicked = 0;
  });

  // Definition Functions

  function setClear() {
    jQuery('#'+triID).css( "opacity", "0" );
    jQuery('#'+triID).css( "fill", "transparent" );
    jQuery('#'+triID).css( "filter", "drop-shadow( 0px 0px 0px transparent )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( 0px 0px 0px transparent )" );
  };

  function setBlack() {
    jQuery('#'+triID).css( "fill", "#111111" );
    jQuery('#'+triID).css( "filter", "drop-shadow( 0px 0px 0px rgba(0,0,0,0) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( 0px 0px 0px rgba(0,0,0,0) )" );
  };

  function setGreen() {
    jQuery('#'+triID).css( "fill", "#3fa94c" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(63,169,76,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(63,169,76,1) )" );
  };

  function setBlue() {
    jQuery('#'+triID).css( "fill", "#00a4d8" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(0,164,216,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(0,164,216,1) )" );
  };

  function setRed() {
    jQuery('#'+triID).css( "fill", "#d62631" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(214,38,49,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(214,38,49,1) )" );
  };

  function setYellow() {
    jQuery('#'+triID).css( "fill", "#ffef36" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(255,239,54,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(255,239,54,1) )" );
  };

  function setPink() {
    jQuery('#'+triID).css( "fill", "#d61d7d" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(214,29,125,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(214,29,125,1) )" );
  };

  function setWhite() {
    jQuery('#'+triID).css( "fill", "rgba(255,255,255,.8)" );
    jQuery('#'+triID).css( "filter", "drop-shadow( -0px -0px 8px rgba(255,255,255,1) )" );
    jQuery('#'+triID).css( "-webkit-filter", "drop-shadow( -0px -0px 8px rgba(255,255,255,1) )" );
  };

  function setRGB() {
    setClear();
    animateFlash();
    setRed();
    jQuery( ".triangle" ).animate({
    opacity: "1"
  }, 500, function() {
      setClear();
      animateFlash();
      setGreen();
      jQuery( ".triangle" ).animate({
      opacity: "1"
    }, 500, function() {
        setClear();
        animateFlash();
        setBlue();
        jQuery( ".triangle" ).animate({
        opacity: "1"
      }, 500, function() {
          //
        });
      });
    });
  };

  function setYB() {
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    jQuery( ".triangle" ).animate({
      opacity: "1"
    }, 500, function() {
      setClear();
      animateFlash();
      setBlue();
      setClear();
      animateFlash();
      setBlue();
      setClear();
      animateFlash();
      setBlue();
      setClear();
      animateFlash();
      setBlue();
      setClear();
      animateFlash();
      setBlue();
    });
  };

  function animateFlash() {
    jQuery( '#'+triID ).animate({opacity: 0}, "normal");
    jQuery( '#'+triID ).animate({opacity: 1}, "normal");
  };

  function animateBlink() {
    jQuery( '#'+triID ).animate({opacity: 0}, 50);
    jQuery( '#'+triID ).animate({opacity: 1}, 50);
  };

  function animateVibe() {
    if (jQuery(window).width() < 642 ) {
      jQuery( ".led-cam" ).animate({marginLeft: -4}, 100);
      jQuery( ".led-cam" ).animate({marginLeft: 8}, 100);
      jQuery( ".led-cam" ).animate({marginLeft: -4}, 100);
    }
    else {
      jQuery( ".led-camera" ).animate({marginLeft: -4}, 100);
      jQuery( ".led-camera" ).animate({marginLeft: 8}, 100);
      jQuery( ".led-camera" ).animate({marginLeft: -4}, 100);
    }
  };

  function animateVibe3() {
    var times = 3;
    var loop = setInterval(anim, 800);
    function anim(){
        times--;
        if(times === 0){clearInterval(loop);}
        animateVibe();
    }
    anim();
  };

  function setText() {
    jQuery( "#Powered_Off li span" ).html( "Powered Off" );
    jQuery( "#Powered_Off li span" ).removeClass( "active" );
    jQuery( "#Fully_Charged li span" ).html( "Fully Charged" );
    jQuery( "#Fully_Charged li span" ).removeClass( "active" );
    jQuery( "#Charging li span" ).html( "Charging" );
    jQuery( "#Charging li span" ).removeClass( "active" );
    jQuery( "#Ready li span" ).html( "Ready" );
    jQuery( "#Ready li span" ).removeClass( "active" );
    jQuery( "#BootingShutting li span" ).html( "Booting/Shutting Down" );
    jQuery( "#BootingShutting li span" ).removeClass( "active" );
    jQuery( "#Discovering li span" ).html( "Discovering" );
    jQuery( "#Discovering li span" ).removeClass( "active" );
    jQuery( "#Recording li span" ).html( "Recording" );
    jQuery( "#Recording li span" ).removeClass( "active" );
    jQuery( "#Recording_LED_LowM li span" ).html( "Recording (low memory)" );
    jQuery( "#Recording_LED_LowM li span" ).removeClass( "active" );
    jQuery( "#Recording_LED_NoM li span" ).html( "Recording (no memory)" );
    jQuery( "#Recording_LED_NoM li span" ).removeClass( "active" );
    jQuery( "#Low_Battery li span" ).html( "Low Battery (<30%)" );
    jQuery( "#Low_Battery li span" ).removeClass( "active" );
    jQuery( "#Firmware_Update li span" ).html( "Firmware Update" );
    jQuery( "#Firmware_Update li span" ).removeClass( "active" );
    jQuery( "#Factory_Reset li span" ).html( "Factory Reset" );
    jQuery( "#Factory_Reset li span" ).removeClass( "active" );
    jQuery( "#Warnings_Errors li span" ).html( "Warnings/Errors" );
    jQuery( "#Warnings_Errors li span" ).removeClass( "active" );
    jQuery( "#Unable_Boot li span" ).html( "Unable to Reboot (error related)" );
    jQuery( "#Unable_Boot li span" ).removeClass( "active" );
    jQuery( "#UMS li span" ).html( "USB Mass Storage" );
    jQuery( "#UMS li span" ).removeClass( "active" );
    jQuery( "#Reformat_Storage li span" ).html( "Reformat Storage" );
    jQuery( "#Reformat_Storage li span" ).removeClass( "active" );
  };

  // Click Functions

  jQuery( "#Powered_Off" ).click(function(e) {
    e.preventDefault();
    setText();
    setClear();
    animateFlash();
    setBlack();
    jQuery( "#Powered_Off li span" ).html( "<strong>Powered Off</strong></br><span>LED Off</span>" );
    jQuery( "#Powered_Off li span" ).addClass( "active" );
    triID = "AnimateTriangle" + triNum++;
  });

  jQuery( "#Fully_Charged" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Fully_Charged li span" ).html( "<strong>Fully Charged</strong> </br><span>Glow</span>" );
    jQuery( "#Fully_Charged li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setGreen();
    triID = "AnimateTriangle" + triNum++;
  });

  jQuery( "#Charging" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Charging li span" ).html( "<strong>Charging</strong> </br><span>Two Flash</span>" );
    jQuery( "#Charging li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setGreen();
    setClear();
    animateFlash();
    setGreen();
  });

  jQuery( "#Ready" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Ready li span" ).html( "<strong>Ready</strong> </br><span>Glow</span>" );
    jQuery( "#Ready li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setBlue();
  });

  jQuery( "#BootingShutting" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#BootingShutting li span" ).html( "<strong>Booting/Shutting Down</strong> </br><span>Flash/Vibe</span>" );
    jQuery( "#BootingShutting li span" ).addClass( "active" );
    animateVibe3();
    setClear();
    animateFlash();
    setBlue();
    setClear();
    animateFlash();
    setBlue();
    setClear();
    animateFlash();
    setBlue();
    setClear();
    animateFlash();
    setBlue();
    setClear();
    animateFlash();
    setBlue();
  });

  jQuery( "#Discovering" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Discovering li span" ).html( "<strong>Discovering</strong> </br><span>Flash 3</span>" );
    jQuery( "#Discovering li span" ).addClass( "active" );
    setClear();
    setRGB();
  });

  jQuery( "#Recording" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Recording li span" ).html( "<strong>Recording</strong> </br><span>Flash/Vibe</span>" );
    jQuery( "#Recording li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setRed();
    animateVibe3()
  });

  jQuery( "#Recording_LED_LowM" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Recording_LED_LowM li span" ).html( "<strong>Recording (low memory)</strong> </br><span>Blink 2</span>" );
    jQuery( "#Recording_LED_LowM li span" ).addClass( "active" );
    setClear();
    animateBlink();
    setRed();
    setClear();
    animateBlink();
    setRed();
  });

  jQuery( "#Recording_LED_NoM" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Recording_LED_NoM li span" ).html( "<strong>Recording (no memory)</strong> </br><span>Flash Loop</span>" );
    jQuery( "#Recording_LED_NoM li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setRed();
    setClear();
    animateFlash();
    setRed();
    setClear();
    animateFlash();
    setRed();
    setClear();
    animateFlash();
    setRed();
    setClear();
    animateFlash();
    setRed();
  });

  jQuery( "#Low_Battery" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Low_Battery li span" ).html( "<strong>Low Battery (<30%)</strong> </br><span>Flash Loop</span>" );
    jQuery( "#Low_Battery li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setPink();
    setClear();
    animateFlash();
    setPink();
    setClear();
    animateFlash();
    setPink();
    setClear();
    animateFlash();
    setPink();
    setClear();
    animateFlash();
    setPink();
  });

  jQuery( "#Firmware_Update" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Firmware_Update li span" ).html( "<strong>Firmware Update</strong> </br><span> Flash Loop</span>" );
    jQuery( "#Firmware_Update li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
    setClear();
    animateFlash();
    setYellow();
  });

  jQuery( "#Factory_Reset" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Factory_Reset li span" ).html( "<strong>Factory Reset</strong> </br><span>Flash Loop</span>" );
    jQuery( "#Factory_Reset li span" ).addClass( "active" );
    setClear();
    setYB();
  });

  jQuery( "#Warnings_Errors" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Warnings_Errors li span" ).html( "<strong>Warnings/Errors</strong> </br><span>Blinking</span>" );
    jQuery( "#Warnings_Errors li span" ).addClass( "active" );
    setClear();
    animateBlink();
    setWhite();
    animateBlink();
    animateBlink();
    animateBlink();
    animateBlink();
    animateBlink();
  });

  jQuery( "#Unable_Boot" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Unable_Boot li span" ).html( "<strong>Unable to Reboot</strong> </br><span>Flash 5</span>" );
    jQuery( "#Unable_Boot li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setWhite();
    setClear();
    animateFlash();
    setWhite();
    setClear();
    animateFlash();
    setWhite();
    setClear();
    animateFlash();
    setWhite();
    setClear();
    animateFlash();
    setWhite();
  });

  jQuery( "#UMS" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#UMS li span" ).html( "<strong>USB Mass Storage</strong> </br><span>Glow</span>" );
    jQuery( "#UMS li span" ).addClass( "active" );
    setClear();
    animateFlash();
    setYellow();
  });

  jQuery( "#Reformat_Storage" ).click(function(e) {
    e.preventDefault();
    setText();
    jQuery( "#Reformat_Storage li span" ).html( "<strong>Reformat Storage</strong> </br><span>Flash Loop</span>" );
    jQuery( "#Reformat_Storage li span" ).addClass( "active" );
    setClear();
    setYB();
  });

});
