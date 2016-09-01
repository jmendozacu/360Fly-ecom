var base_url = 'http://360fly.magenyc.com/html/';
$(document).ready(function() {
	
	$('.product-slider').slick({
		centerMode: true,
		centerPadding: '0px',
		slidesToShow: 3,
		prevArrow: '<i class="slick-prev left fa fa-angle-left"></i>',
        nextArrow: '<i class="slick-next right fa fa-angle-right"></i>',
		responsive: [
		{
		  breakpoint: 768,
		  settings: {
			arrows: false,
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 1
		  }
		},
		{
		  breakpoint: 480,
		  settings: {
			arrows: false,
			centerMode: true,
			centerPadding: '0px',
			slidesToShow: 1
		  }
		}
		]
	});


    $('#layerslider').layerSlider({
        responsive: false,
        responsiveUnder: 1000,
        layersContainer: 1000,
        autoStart: false,
        skinsPath: base_url+'skins/',
        globalBGColor: 'black',
        navStartStop: false,
        thumbnailNavigation: 'disabled',
        autoPlayVideos: false,
        cbPrev: function() {
            if ($('#trump-ad').children().length > 0) {
                $('#trump-ad').find('iframe').remove();
            }
        },
        cbNext: function() {
            if ($('#trump-ad').children().length > 0) {
                $('#trump-ad').find('iframe').remove();
            }
        }
    });


    if (navigator.userAgent.toLowerCase().indexOf("android") > -1) {
        $('.app-slide').append("<a href='https://play.google.com/store/apps/details?id=com.livitnow.livit&hl=en' class='ls-link'></a>");
    }
    if (navigator.userAgent.toLowerCase().indexOf("iphone") > -1) {
        $('.app-slide').append("<a href='https://itunes.apple.com/us/app/livit-live-video-and-vr/id896514048?mt=8' class='ls-link'></a>");
    }
    $('#trump-trigger').on('click', function() {
        $('#trump-ad').append('<iframe width="1000" height="563" src="https://www.youtube.com/embed/Pllco4cJCVU?rel=0&amp;controls=0&amp;showinfo=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
    });

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

function preloadImages(imageArray) {
    for (i = 0; i < imageArray.length; i++) {
        var imageObject = new Image();
        imageObject.src = imageArray[i];
    }
}

// point of view
var pov_images = [
    base_url+"images/parallax/pov/pov__imagesequence_01.png",
    base_url+"images/parallax/pov/pov__imagesequence_02.png",
    base_url+"images/parallax/pov/pov__imagesequence_03.png",
    base_url+"images/parallax/pov/pov__imagesequence_04.png",
    base_url+"images/parallax/pov/pov__imagesequence_05.png",
    base_url+"images/parallax/pov/pov__imagesequence_06.png",
    base_url+"images/parallax/pov/pov__imagesequence_07.png",
    base_url+"images/parallax/pov/pov__imagesequence_08.png",
    base_url+"images/parallax/pov/pov__imagesequence_09.png",
    base_url+"images/parallax/pov/pov__imagesequence_10.png",
    base_url+"images/parallax/pov/pov__imagesequence_11.png",
    base_url+"images/parallax/pov/pov__imagesequence_12.png",
    base_url+"images/parallax/pov/pov__imagesequence_13.png",
    base_url+"images/parallax/pov/pov__imagesequence_14.png",
    base_url+"images/parallax/pov/pov__imagesequence_15.png",
    base_url+"images/parallax/pov/pov__imagesequence_16.png",
    base_url+"images/parallax/pov/pov__imagesequence_17.png"
];
preloadImages(pov_images);

var pov_obj = {
    curImg: 0
};
var pov_tween = TweenMax.to(pov_obj, 0.5, {
    curImg: pov_images.length - 1,
    roundProps: "curImg",
    repeat: 0,
    immediateRender: true,
    ease: Linear.easeNone,
    onUpdate: function() {
        $('#hand-wrap img').attr("src", pov_images[pov_obj.curImg]);
    }
});
var pov_controller = new ScrollMagic.Controller();
var pov_scene = new ScrollMagic.Scene({
    triggerElement: ".hand",
    triggerHook: "onEnter",
    duration: "500",
    offset: 300
}).setTween(pov_tween).addTo(pov_controller);

//field of view
var fov_images = [
    base_url+"images/parallax/fov/fov__imagesequence_01.png",
    base_url+"images/parallax/fov/fov__imagesequence_01.png",
    base_url+"images/parallax/fov/fov__imagesequence_02.png",
    base_url+"images/parallax/fov/fov__imagesequence_02.png",
    base_url+"images/parallax/fov/fov__imagesequence_03.png",
    base_url+"images/parallax/fov/fov__imagesequence_03.png",
    base_url+"images/parallax/fov/fov__imagesequence_04.png",
    base_url+"images/parallax/fov/fov__imagesequence_04.png",
    base_url+"images/parallax/fov/fov__imagesequence_05.png",
    base_url+"images/parallax/fov/fov__imagesequence_05.png",
    base_url+"images/parallax/fov/fov__imagesequence_06.png",
    base_url+"images/parallax/fov/fov__imagesequence_06.png",
    base_url+"images/parallax/fov/fov__imagesequence_07.png",
    base_url+"images/parallax/fov/fov__imagesequence_07.png",
    base_url+"images/parallax/fov/fov__imagesequence_08.png",
    base_url+"images/parallax/fov/fov__imagesequence_08.png",
    base_url+"images/parallax/fov/fov__imagesequence_09.png",
    base_url+"images/parallax/fov/fov__imagesequence_09.png",
    base_url+"images/parallax/fov/fov__imagesequence_10.png",
    base_url+"images/parallax/fov/fov__imagesequence_10.png",
    base_url+"images/parallax/fov/fov__imagesequence_11.png",
    base_url+"images/parallax/fov/fov__imagesequence_11.png",
    base_url+"images/parallax/fov/fov__imagesequence_12.png",
    base_url+"images/parallax/fov/fov__imagesequence_12.png",
    base_url+"images/parallax/fov/fov__imagesequence_13.png",
    base_url+"images/parallax/fov/fov__imagesequence_13.png",
    base_url+"images/parallax/fov/fov__imagesequence_14.png",
    base_url+"images/parallax/fov/fov__imagesequence_14.png",
    base_url+"images/parallax/fov/fov__imagesequence_15.png",
    base_url+"images/parallax/fov/fov__imagesequence_15.png",
    base_url+"images/parallax/fov/fov__imagesequence_16.png",
    base_url+"images/parallax/fov/fov__imagesequence_16.png",
    base_url+"images/parallax/fov/fov__imagesequence_17.png",
    base_url+"images/parallax/fov/fov__imagesequence_17.png",
    base_url+"images/parallax/fov/fov__imagesequence_18.png",
    base_url+"images/parallax/fov/fov__imagesequence_18.png",
    base_url+"images/parallax/fov/fov__imagesequence_19.png",
    base_url+"images/parallax/fov/fov__imagesequence_19.png",
    base_url+"images/parallax/fov/fov__imagesequence_20.png",
    base_url+"images/parallax/fov/fov__imagesequence_21.png",
    base_url+"images/parallax/fov/fov__imagesequence_21.png",
    base_url+"images/parallax/fov/fov__imagesequence_22.png",
    base_url+"images/parallax/fov/fov__imagesequence_22.png",
    base_url+"images/parallax/fov/fov__imagesequence_23.png",
    base_url+"images/parallax/fov/fov__imagesequence_23.png",
    base_url+"images/parallax/fov/fov__imagesequence_24.png",
    base_url+"images/parallax/fov/fov__imagesequence_24.png",
    base_url+"images/parallax/fov/fov__imagesequence_25.png",
    base_url+"images/parallax/fov/fov__imagesequence_25.png",
    base_url+"images/parallax/fov/fov__imagesequence_26.png",
    base_url+"images/parallax/fov/fov__imagesequence_26.png",
    base_url+"images/parallax/fov/fov__imagesequence_27.png",
    base_url+"images/parallax/fov/fov__imagesequence_27.png",
    base_url+"images/parallax/fov/fov__imagesequence_28.png",
    base_url+"images/parallax/fov/fov__imagesequence_28.png",
    base_url+"images/parallax/fov/fov__imagesequence_29.png",
    base_url+"images/parallax/fov/fov__imagesequence_29.png",
    base_url+"images/parallax/fov/fov__imagesequence_30.png",
    base_url+"images/parallax/fov/fov__imagesequence_30.png",
    base_url+"images/parallax/fov/fov__imagesequence_31.png",
    base_url+"images/parallax/fov/fov__imagesequence_31.png",
    base_url+"images/parallax/fov/fov__imagesequence_32.png",
    base_url+"images/parallax/fov/fov__imagesequence_32.png",
    base_url+"images/parallax/fov/fov__imagesequence_33.png",
    base_url+"images/parallax/fov/fov__imagesequence_33.png",
    base_url+"images/parallax/fov/fov__imagesequence_34.png",
    base_url+"images/parallax/fov/fov__imagesequence_34.png",
    base_url+"images/parallax/fov/fov__imagesequence_35.png",
    base_url+"images/parallax/fov/fov__imagesequence_35.png",
    base_url+"images/parallax/fov/fov__imagesequence_36.png",
    base_url+"images/parallax/fov/fov__imagesequence_36.png",
    base_url+"images/parallax/fov/fov__imagesequence_37.png",
    base_url+"images/parallax/fov/fov__imagesequence_38.png",
    base_url+"images/parallax/fov/fov__imagesequence_39.png",
    base_url+"images/parallax/fov/fov__imagesequence_40.png",
    base_url+"images/parallax/fov/fov__imagesequence_41.png",
    base_url+"images/parallax/fov/fov__imagesequence_41.png",
    base_url+"images/parallax/fov/fov__imagesequence_42.png",
    base_url+"images/parallax/fov/fov__imagesequence_42.png",
    base_url+"images/parallax/fov/fov__imagesequence_43.png",
    base_url+"images/parallax/fov/fov__imagesequence_43.png",
    base_url+"images/parallax/fov/fov__imagesequence_44.png",
    base_url+"images/parallax/fov/fov__imagesequence_44.png",
    base_url+"images/parallax/fov/fov__imagesequence_45.png",
    base_url+"images/parallax/fov/fov__imagesequence_45.png",
    base_url+"images/parallax/fov/fov__imagesequence_46.png",
    base_url+"images/parallax/fov/fov__imagesequence_46.png",
    base_url+"images/parallax/fov/fov__imagesequence_47.png",
    base_url+"images/parallax/fov/fov__imagesequence_48.png",
    base_url+"images/parallax/fov/fov__imagesequence_49.png",
    base_url+"images/parallax/fov/fov__imagesequence_50.png",
    base_url+"images/parallax/fov/fov__imagesequence_51.png",
    base_url+"images/parallax/fov/fov__imagesequence_51.png",
    base_url+"images/parallax/fov/fov__imagesequence_52.png",
    base_url+"images/parallax/fov/fov__imagesequence_52.png",
    base_url+"images/parallax/fov/fov__imagesequence_53.png",
    base_url+"images/parallax/fov/fov__imagesequence_53.png",
    base_url+"images/parallax/fov/fov__imagesequence_54.png",
    base_url+"images/parallax/fov/fov__imagesequence_54.png",
    base_url+"images/parallax/fov/fov__imagesequence_55.png",
    base_url+"images/parallax/fov/fov__imagesequence_55.png",
    base_url+"images/parallax/fov/fov__imagesequence_56.png",
    base_url+"images/parallax/fov/fov__imagesequence_56.png",
    base_url+"images/parallax/fov/fov__imagesequence_57.png",
    base_url+"images/parallax/fov/fov__imagesequence_58.png",
    base_url+"images/parallax/fov/fov__imagesequence_59.png",
    base_url+"images/parallax/fov/fov__imagesequence_60.png",
    base_url+"images/parallax/fov/fov__imagesequence_61.png",
    base_url+"images/parallax/fov/fov__imagesequence_61.png",
    base_url+"images/parallax/fov/fov__imagesequence_62.png",
    base_url+"images/parallax/fov/fov__imagesequence_62.png",
    base_url+"images/parallax/fov/fov__imagesequence_63.png",
    base_url+"images/parallax/fov/fov__imagesequence_63.png",
    base_url+"images/parallax/fov/fov__imagesequence_64.png",
    base_url+"images/parallax/fov/fov__imagesequence_64.png",
    base_url+"images/parallax/fov/fov__imagesequence_65.png",
    base_url+"images/parallax/fov/fov__imagesequence_65.png",
    base_url+"images/parallax/fov/fov__imagesequence_66.png",
    base_url+"images/parallax/fov/fov__imagesequence_66.png",
    base_url+"images/parallax/fov/fov__imagesequence_67.png",
    base_url+"images/parallax/fov/fov__imagesequence_68.png",
    base_url+"images/parallax/fov/fov__imagesequence_69.png",
    base_url+"images/parallax/fov/fov__imagesequence_70.png",
    base_url+"images/parallax/fov/fov__imagesequence_71.png",
    base_url+"images/parallax/fov/fov__imagesequence_71.png"
];
preloadImages(fov_images);

var fov_obj = {
    curImg: 0
};
var fov_tween = TweenMax.to(fov_obj, 0.5, {
    curImg: fov_images.length - 1,
    roundProps: "curImg",
    repeat: 0,
    immediateRender: true,
    ease: Linear.easeNone,
    onUpdate: function() {
        $('#globe-wrap img').attr("src", fov_images[fov_obj.curImg]);
    }
});
var fov_controller = new ScrollMagic.Controller();
var fov_scene = new ScrollMagic.Scene({
    triggerElement: "#globe-wrap",
    triggerHook: "onEnter",
    duration: "130%"
}).setTween(fov_tween).addTo(fov_controller);


/* initiate animations */
function createAnimation() {
    this.controller = new ScrollMagic.Controller();
    this.scenes = [];
}

createAnimation.prototype = {
    controller: null,
    scenes: null,
    constructor: createAnimation,
    create: function(element, args) {
        element = typeof element === "string" ?
            document.getElementById(element) :
            element;
        var tween = TweenMax.to(element, args.tween.duration, args.tween.options),
            scene = new ScrollMagic.Scene(args.scene.options);

        scene.setTween(tween)
        scene.addTo(this.controller);

        this.scenes.push(scene);

        return this;
    }
}

/* create dirt animations */
var dirtAnimation = new createAnimation();
dirtAnimation.create("dirt-camera", {
    tween: {
        duration: .5,
        options: {
            ease: Power2.easeOut,
            opacity: 1,
            top: "+=842",
            rotation: 360
        }
    },
    scene: {
        options: {
            triggerElement: ".dirt",
            duration: "500"
        }
    }
}).create("dirt-spray-front", {
    tween: {
        duration: .5,
        options: {
            css: {
                scale: "1",
                top: "-=100"
            }
        }
    },
    scene: {
        options: {
            triggerElement: ".dirt",
            offset: 335,
            duration: "200"
        }
    }
}).create("dirt-back-spray-1", {
    tween: {
        duration: .5,
        options: {
            css: {
                scale: "1",
                top: "-=180"
            }
        }
    },
    scene: {
        options: {
            triggerElement: ".dirt",
            offset: 335,
            duration: "200"
        }
    }
}).create("dirt-back-spray-2", {
    tween: {
        duration: .5,
        options: {
            css: {
                scale: "1",
                top: "-559"
            }
        }
    },
    scene: {
        options: {
            triggerElement: ".dirt",
            offset: 335,
            duration: "200"
        }
    }
});