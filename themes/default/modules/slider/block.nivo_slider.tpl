<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/themes/default/default.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/themes/light/light.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/themes/dark/dark.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/themes/bar/bar.css" type="text/css" media="screen" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/nivo-slider.css" type="text/css" media="screen" />
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/nivoslider/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<div class="slider-wrapper theme-default">
	<div id="slider" class="nivoSlider">
		<!-- BEGIN: loop -->
		<a href="{DATA.link}" title="{DATA.title}">
			<img src="{DATA.image}" alt="{DATA.title}" title="{DATA.title}"  />
		</a>
		<!-- END: loop -->      
	</div>
</div>
<script type="text/javascript">
	$(window).load(function () {
		$('#slider').nivoSlider({
			effect: 'sliceDown', // Specify sets like: 'fold,fade,sliceDown'
			slices: 15, // For slice animations
			boxRows: 1, // For box animations
			animSpeed: 500, // Slide transition speed
			pauseTime: 5000, // How long each slide will show
            randomStart: true, // auto play
			startSlide: 0, // Set starting Slide (0 index)
            directionNav: true, // Next & Prev navigation
            directionNavHide: true, // Only show on hover
            controlNav: true, // 1,2,3... navigation
            controlNavThumbs: false, // Use thumbnails for Control Nav
            controlNavThumbsFromRel: false, // Use image rel for thumbs
            controlNavThumbsSearch: '.jpg', // Replace this with...
            controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
            keyboardNav: true, // Use left & right arrows
            pauseOnHover: true, // Stop animation while hovering
            manualAdvance: false, // Force manual transitions
            captionOpacity: 0, // Universal caption opacity
            prevText: 'Prev', // Prev directionNav text
			nextText: 'Next', // Next directionNav text
			beforeChange: function () { }, // Triggers before a slide transition
			afterChange: function () { }, // Triggers after a slide transition
			slideshowEnd: function () { }, // Triggers after all slides have been shown
			lastSlide: function () { }, // Triggers when last slide is shown
			afterLoad: function () { $('#slider a').css('display','block') } // Triggers when slider has loaded
		});
	});
</script>
<!-- END: main --> 