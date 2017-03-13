<div id="main" role="main">
	<section class="slider z-slider">
		<div class="flexslider ">
			<ul class="slides">
				<li data-thumb="assets/img/products/hd1.png">
					<img src="assets/img/products/hd1.png" alt="360fly 4K" title="360fly 4K"/>
				</li>
				<li data-thumb="assets/img/products/hd2.png">
					<img src="assets/img/products/hd2.png" alt="360fly 4K" title="360fly 4K"/>
				</li>
				<li data-thumb="assets/img/products/hd3.png">
					<img src="assets/img/products/hd3.png" alt="360fly 4K" title="360fly 4K"/>
				</li>
				<li data-thumb="assets/img/products/hd4.png" class="z-video-play">
					<img src="assets/img/products/hd4.png" alt="360fly 4K" title="360fly 4K"/>
				</li>
			 </ul>
		</div>
	</section>
</div>

<script>
	jQuery(window).load(function(){
		jQuery('.flexslider').flexslider({
			animation: "slide",
			controlNav: "thumbnails",
			itemMargin: 0,
			easing: "swing",
			touch: "true",
			slideshow: "false",
			directionNav: true,

		});
    });
</script>
