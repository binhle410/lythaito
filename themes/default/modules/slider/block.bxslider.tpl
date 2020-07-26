<!-- BEGIN: main -->
<!-- BEGIN: load_bxslider -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/bxslider/jquery.bxslider.css" media="all"/>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/images/{MOD_FILE}/plugins/bxslider/jquery.bxslider.min.js"></script>
<!-- END: load_bxslider -->
<div id="nvslider1" >
    <ul id="slider1"class="bxslider" style="visibility:hidden">
		<!-- BEGIN: loop -->
        <li>
            <a href="{DATA.link}" title="{DATA.title}">
                <img alt="{DATA.title}" src="{DATA.image}" title="{DATA.title}"  />
            </a>
        </li>
		<!-- END: loop -->
	</ul>
</div>
<script type="text/javascript">
$('#slider1').bxSlider({auto: true, adaptiveHeight: true, mode: 'horizontal', onSliderLoad: function(){
	$('#slider1').css("visibility", "visible");
}});
</script>
<!-- END: main -->

