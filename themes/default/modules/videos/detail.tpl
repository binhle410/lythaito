<!-- BEGIN: main -->
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.pack.js"></script>
<script src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.MetaData.js" type="text/javascript"></script>
<link href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/star-rating/jquery.rating.css" type="text/css" rel="stylesheet"/>

<div class="detail_container col-xs-24 col-md-24 col-lg-24">
	<div class="detail_video row">
		<div class="detail_header cf">
			<h3 class="title">{DETAIL.title}</h3>
			<!-- BEGIN: socialbutton -->
			<div class="social-icon col-xs-12 col-md-12 col-lg-12 clearfix margin-bottom-lg margin-top-lg">
				<div class="fb-like" data-href="{SELFURL}" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true">&nbsp;</div>
			</div>
			<div class="clearfix"></div>
			<!-- END: socialbutton -->
		</div>
		<!-- BEGIN: no_jwp_lic_admin -->
		<div class="alert alert-warning"><a href="{SETTING_LINKS}" title="{LANG.no_jwp_lic_admin}"><strong>{LANG.no_jwp_lic_admin}</strong>&nbsp;<em class="fa fa-external-link"></em></a> </div>
		<!-- END: no_jwp_lic_admin -->

		<!-- BEGIN: no_jwp_lic -->
		<div class="alert alert-warning"><strong>{LANG.no_jwp_lic}</strong></div>
		<!-- END: no_jwp_lic -->

		<div class="videoplayer cf">
			<!-- BEGIN: vid_jw_content -->
			<div id="videoCont_{DETAIL.id}">
				<i class="fa fa-spinner fa-pulse fa-3x fa-fw center-block"></i>
			</div>
			<!-- END: vid_jw_content -->
		</div>
		<div class="uploader cf margin-bottom-lg margin-top-lg">
			<div class="pd0 col-xs-2 col-md-2 col-sm-2 col-lg-2">
				<a href="{DETAIL.uploader_link}" title="{DETAIL.uploader_name}">
				<img src="{DETAIL.uploader_gravatar}" alt="{DETAIL.uploader_name}" title="{DETAIL.uploader_name}" class="img-thumbnail img-responsive">
				</a>
			</div>
			
			<div class="col-md-18 col-sm-18 col-lg-18">
				<p><a href="{DETAIL.uploader_link}" title="{DETAIL.uploader_name}"><strong>{DETAIL.uploader_name}</strong></a></p>
				<p>{DETAIL.publtime}</p>
			</div>
			
			<!-- BEGIN: hitstotal -->
			<div class="hitstotal col-md-4 col-sm-4 col-lg-4 pull-right">
				{DETAIL.hitstotal}&nbsp;{LANG.hits_view}
			</div>
			<!-- END: hitstotal -->
		</div>
		<div class="media-func group fn-tabgroup">
			<a title="{LANG.playlist_add_video}"<!-- BEGIN: not_user --> onclick="nv_colapse_report(); return loginForm();"<!-- END: not_user --><!-- BEGIN: plist_is_user --> onclick="nv_colapse_report( );" data-toggle="collapse" data-target="#add_to_userlist"<!-- END: plist_is_user --> href="#" class="button-style-1 fn-tab">
			<span><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;{LANG.playlist_add_video}</span>
			</a>
			
			<a title="{LANG.video_favorite}"<!-- BEGIN: not_user --> onclick="return loginForm();"<!-- END: not_user --> <!-- BEGIN: favorite_is_user --> onclick="nv_favourite_videos('{DETAIL.id}','fav','{NEWSCHECKSS}','{DETAIL.check_session}');"<!-- END: favorite_is_user --> href="#" class="button-style-1 fn-tab">
			<span id="favourite-{DETAIL.id}"></span>
			</a>
			
			<a title="{LANG.video_report}" href="#" class="button-style-1 fn-tab" data-toggle="collapse" data-target="#report_videos" onclick="nv_colapse_favourites( );">
			<span><i class="fa fa-flag" aria-hidden="true"></i>&nbsp;{LANG.video_report}</span>
			</a>
			
			<div id="add_to_userlist" class="show_playlist clear collapse add-playlist-region" value="{DETAIL.id}">
			</div>
			
			<div id="report_videos" class="show_report clear collapse add-playlist-region">
				<div class="add-playlist-region report">
					<h4 class="margin-bottom-lg">
						<span class="margin-bottom-lg">{LANG.report_select}</span>
						<span title="Close" class="close fn-closetab" data-toggle="collapse" data-target="#report_videos"><i class="fa fa-times" aria-hidden="true"></i></span>
					</h4>
					<!-- BEGIN: report_videos -->
					<input type="radio" title="{REPORT.title}" name="report_videos" value="{REPORT.value}">{REPORT.title}<br>
					<!-- END: report_videos -->
				<a class="btn btn-primary fix-button fn-add margin-top-lg" onclick="nv_report_videos('{DETAIL.id}', '{NEWSCHECKSS}');">
					<span class="report-video">{LANG.report_send}</span>
				</a>
				</div>
			</div>
		</div>
	</div>
	<!-- BEGIN: no_public -->
	<div class="clear">
		<div class="alert alert-warning">
			{LANG.no_public}
		</div>
	</div>
	<!-- END: no_public -->

	<!-- BEGIN: bodyhtml -->
	<div class="panel panel-default bodytext_shorten row">
		<div id="news-bodyhtml" class="bodytext panel-body margin-bottom-lg">
			{DETAIL.bodyhtml}
		</div>
	</div>
	<!-- END: bodyhtml -->
	<!-- BEGIN: author -->
	<div class="clear margin-bottom-lg">
		<!-- BEGIN: name -->
		<p class="h5 text-right">
			<strong>{LANG.author}: </strong>{DETAIL.author}
		</p>
		<!-- END: name -->
		<p class="h5 text-right">
			<strong>{LANG.artist}: </strong>{DETAIL.artist}
		</p>
		<!-- BEGIN: source -->
		<p class="h5 text-right">
			<strong>{LANG.source}: </strong>{DETAIL.source}
		</p>
		<!-- END: source -->
	</div>
	<!-- END: author -->
	<!-- BEGIN: copyright -->
	<div class="row alert alert-info margin-bottom-lg">
		{COPYRIGHT}
	</div>
	<!-- END: copyright -->
</div>
<!-- BEGIN: allowed_rating -->
<div class="panel panel-default clear">
	<div class="news_column panel-body">
		<div class="col-md-24">
			<form id="form3B" action="">
				<div class="h5 clearfix">
					<p>{STRINGRATING}</p>
					<!-- BEGIN: data_rating -->
					<span itemscope itemtype="http://data-vocabulary.org/Review-aggregate">{LANG.rating_average}:
						<span itemprop="rating">{DETAIL.numberrating}</span> -
						<span itemprop="votes">{DETAIL.click_rating}</span> {LANG.rating_count}
					</span>
					<!-- END: data_rating -->
					<div style="padding: 5px;">
						<input class="hover-star" type="radio" value="1" title="{LANGSTAR.verypoor}" /><input class="hover-star" type="radio" value="2" title="{LANGSTAR.poor}" /><input class="hover-star" type="radio" value="3" title="{LANGSTAR.ok}" /><input class="hover-star" type="radio" value="4" title="{LANGSTAR.good}" /><input class="hover-star" type="radio" value="5" title="{LANGSTAR.verygood}" /><span id="hover-test" style="margin: 0 0 0 20px;"></span>
					</div>
				</div>
			</form>
		<script>
		$(function() {
			var sr = 0;
			$(".hover-star").rating({
				focus: function(b, c) {
					var a = $("#hover-test");
					2 != sr && (a[0].data = a[0].data || a.html(), a.html(c.title || "value: " + b), sr = 1)
				},
				blur: function(b, c) {
					var a = $("#hover-test");
					2 != sr && ($("#hover-test").html(a[0].data || ""), sr = 1)
				},
				callback: function(b, c) {
					1 == sr && (sr = 2, $(".hover-star").rating("disable"), sendrating("{NEWSID}", b, "{NEWSCHECKSS}"))
				}
			});
			$(".hover-star").rating("select", "{NUMBERRATING}");
			<!-- BEGIN: disablerating -->
			$(".hover-star").rating('disable');
			sr = 2;
			<!-- END: disablerating -->
		})
		</script>
		</div>
	</div>
</div>
<!-- END: allowed_rating -->

<!-- BEGIN: keywords -->
<div class="panel panel-default">
	<div class="news_column panel-body">
		<em class="fa fa-tags">&nbsp;</em>
		<!-- BEGIN: loop -->
		<a class="video-tags btn btn-default" title="{KEYWORD}" href="{LINK_KEYWORDS}">
		<em>{KEYWORD}</em>
		</a>
		<!-- END: loop -->
	</div>
</div>
<!-- END: keywords -->

<!-- BEGIN: adminlink -->
<p class="text-center margin-bottom-lg">
    {ADMINLINK}
</p>
<!-- END: adminlink -->

<!-- BEGIN: comment -->
<div class="panel panel-default">
	<div class="panel-body">
		<div class="comment_box">
		{CONTENT_COMMENT}
		</div>
	</div>
</div>
<!-- END: comment -->

<!-- BEGIN: jwplayer_js -->
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/default/modules/{MODULE_FILE}/jwplayer/jwplayer.js"></script>
<script type="text/javascript">jwplayer.key="{VIDEO_CONFIG.jwplayer_license}";</script>
<!-- END: jwplayer_js -->

<!-- BEGIN: jwplayer -->
<script type="text/javascript">
var playerInstance_{DETAIL.id} = jwplayer("videoCont_{DETAIL.id}");
playerInstance_{DETAIL.id}.setup({
	image: "{DETAIL.image.src}",
	autostart: {VIDEO_CONFIG.jwplayer_autoplay},
	aspectratio: "16:9",
	controls: {VIDEO_CONFIG.jwplayer_controlbar},
	displaydescription: true,
	playlist: "{DETAIL.player}",
	displaytitle: true,
	flashplayer: "{NV_BASE_SITEURL}themes/default/modules/{MODULE_FILE}/jwplayer/jwplayer.flash.swf",
	primary: "html5",
	repeat: {VIDEO_CONFIG.jwplayer_loop},
	mute: {VIDEO_CONFIG.jwplayer_mute},
	<!-- BEGIN: player_logo -->
	logo: {
		file: '{VIDEO_CONFIG.jwplayer_logo_file}',
		link: '{NV_BASE_SITEURL}',
		position: '{VIDEO_CONFIG.jwplayer_position}'
	},
	<!-- END: player_logo -->
	skin: {"name": "stormtrooper"},
	abouttext: "{LANG.jw_video_source}{VIDEO_CONFIG.site_name}",
	aboutlink: "{NV_BASE_SITEURL}",
	stagevideo: false,
	stretching: "uniform",
	visualplaylist: true,
	width: "100%"
  });
</script>
<!-- END: jwplayer -->
<script src="{NV_BASE_SITEURL}themes/default/js/videos_shorten.js" type="text/javascript"></script>
<script language="javascript">
var load_more_text = "{LANG.video_more_text}";
var load_more_text = "{LANG.video_more_text}";
var report_non_check = "{LANG.report_non_check}";
$(document).ready(function() {
	if (document.getElementById('add_to_userlist')) {
		$('#add_to_userlist').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=user_playlist' + '&id={DETAIL.id}' + '&fcheck={DETAIL.check_session}' + '&nocache=' + new Date().getTime());
	}
	if (document.getElementById('favourite-{DETAIL.id}')) {
		$('#favourite-{DETAIL.id}').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=v_funcs&mod_list=get_fav' + '&id={DETAIL.id}' + '&fcheck={DETAIL.check_session}' + '&nocache=' + new Date().getTime());
	}
	$(".bodytext_shorten").shorten({showChars: 200});
});
</script>
<!-- END: main -->

<!-- BEGIN: no_permission -->
<div class="alert alert-info">
	{NO_PERMISSION}
</div>
<!-- END: no_permission -->