<!-- BEGIN: main -->
<!-- BEGIN: load_bxslider -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/bxslider/jquery.bxslider.css" media="all"/>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/bxslider/jquery.bxslider.min.js"></script>
<!-- END: load_bxslider -->
					<div class="pinwheel_slider pinwheel_slider_set4 " style="text-align:center">
	<div id="pinwheel_slider_1_prev" class="pinwheel_prev" style="top:45%;left:8%;" ><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/pinwheel/prev.png" width="32" height="32" /></div>
	<div id="pinwheel_slider_1_next" class="pinwheel_next" style="top:45%;right:10%;" ><img src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/pinwheel/next.png" width="32" height="32" /></div> 
	<div id="pinwheel_slider_1" class="pinwheel_slider_handle" style="width:100%;height:350px;"> 
		<!-- BEGIN: loop -->
		<div class="pinwheel_slideri carousel-feature" >
			<img src="{DATA.image}" alt="{DATA.title}" data-anim="" class="slider_thumbnail full pinwheel_slider_thumbnail carousel-image " width="450" height="300" /><div class="textshow"></div>			 
		</div>
		<!-- END: loop -->
	</div>
</div>

<link rel='stylesheet' id='pinwheel_default-css'  href='{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/pinwheel/pinwheel.css' type='text/css' media='all' />
<script type='text/javascript' src='{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/pinwheel/pinwheel.js'></script>
<script type='text/javascript' src='{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/pinwheel/jquery.touchwipe.js'></script>
 
<script type="text/javascript"> 
$(document).ready(function()
{
	$(".pinwheel_slider_fouc .pinwheel_slider_set4").show();
});
$(document).ready(function(){
	args = {
		animationEasing: "swing",
		carouselSpeed: 800,
		autoPlay: 3000,
		rightButtonTag: "#pinwheel_slider_1_next",
		leftButtonTag: "#pinwheel_slider_1_prev",
		preload: true,
		largeFeatureWidth: 450,
		largeFeatureHeight: 300,
		smallFeatureWidth: 250,
		smallFeatureHeight: 200,
		smallFeatureOffset: 50,
		topPadding: 0,
		sidePadding: 0,
		minimize: false,
		sliderMaxWidth: 900,
		sliderMaxHeight: 300,
		prettyphoto: false,
		slider_handle: "pinwheel_slider_1"
	};
	var pinwheel_slider_1_c = $("#pinwheel_slider_1").pinwheel(args);
	$(window).on("debouncedresize", function()
	{
		pinwheel_slider_1_c.reload(args);
	});
	$("#pinwheel_slider_1").touchwipe(
	{
		wipeLeft: function()
		{
			pinwheel_slider_1_c.next();
		},
		wipeRight: function()
		{
			pinwheel_slider_1_c.prev();
		},
		preventDefaultEvents: false
	});
	$("#pinwheel_slider_1 .wpsc_buy_button").css(
	{
		"background": "#3DB432",
		"font-size": "14px",
		"color": "#ffffff",
		"border": "1px solid #3db432"
	});
});
$('html').addClass('pinwheel_slider_fouc');
$(".pinwheel_slider_fouc .pinwheel_slider_set4").hide();
</script> 
<!-- END: main -->

