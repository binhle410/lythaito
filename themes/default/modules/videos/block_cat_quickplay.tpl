<!-- BEGIN: main -->
	<!-- BEGIN: no_jwp_lic_admin -->
	<div class="alert alert-warning"><a href="{SETTING_LINKS}" title="{LANG.no_jwp_lic_admin}"><strong>{LANG.no_jwp_lic_admin}</strong>&nbsp;<em class="fa fa-external-link"></em></a> </div>
	<!-- END: no_jwp_lic_admin -->

	<!-- BEGIN: no_jwp_lic -->
	<div class="alert alert-warning"><strong>{LANG.no_jwp_lic}</strong></div>
	<!-- END: no_jwp_lic -->

	<div class="videoplayer cf margin-bottom-lg">
		<!-- BEGIN: vid_jw_content -->
		<div id="videoContBlock_{BLOCKID}">
			<i class="fa fa-spinner fa-pulse fa-3x fa-fw center-block"></i>
		</div>
		<!-- END: vid_jw_content -->
	</div>
	<ul>
		<!-- BEGIN: loop -->
		<li class="clearfix">
			<!-- BEGIN: img -->
			<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.thumb}" alt="{ROW.title}" width="60px" class="img-thumbnail pull-left"/></a>
			<!-- END: img -->
			<a title="{ROW.title}" class="show" href="{ROW.link}">{ROW.title}</a>
		</li>
		<!-- END: loop -->
	</ul>
	<!-- BEGIN: jwplayer_js -->
	<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/modules/{MODULE_FILE}/jwplayer/jwplayer.js"></script>
	<script type="text/javascript">jwplayer.key="{VIDEO_CONFIG.jwplayer_license}";</script>
	<!-- END: jwplayer_js -->

	<!-- BEGIN: jwplayer -->
	<script type="text/javascript">
	var blockInstance_{BLOCKID} = jwplayer("videoContBlock_{BLOCKID}");
	blockInstance_{BLOCKID}.setup({
		image: "{ROW.image.src}",
		autostart: {VIDEO_CONFIG.jwplayer_autoplay},
		aspectratio: "16:9",
		controls: {VIDEO_CONFIG.jwplayer_controlbar},
		displaydescription: true,
		playlist: "{PLAYER}",
		displaytitle: true,
		flashplayer: "{NV_BASE_SITEURL}themes/default/modules/{MODULE_FILE}/jwplayer/jwplayer.flash.swf",
		primary: "html5",
		repeat: {VIDEO_CONFIG.jwplayer_loop},
		mute: {VIDEO_CONFIG.jwplayer_mute},
		<!-- BEGIN: player_logo -->
		logo: {
			file: '{VIDEO_CONFIG.jwplayer_logo_file}',
			link: '{NV_MY_DOMAIN}',
			position: '{VIDEO_CONFIG.jwplayer_position}'
		},
		<!-- END: player_logo -->
		skin: {"name": "stormtrooper"},
		abouttext: "{LANG.jw_video_source}{VIDEO_CONFIG.site_name}",
		aboutlink: "{NV_MY_DOMAIN}",
		stagevideo: false,
		stretching: "uniform",
		visualplaylist: true,
		width: "100%"
	  });
	</script>
	<!-- END: jwplayer -->
<!-- END: main -->