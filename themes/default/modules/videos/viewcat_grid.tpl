<!-- BEGIN: main -->
<!-- BEGIN: viewdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h3>{CONTENT.title}</h3>
		<!-- BEGIN: image -->
		<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-thumbnail pull-left imghome" />
		<!-- END: image -->
		<p class="text-justify">{CONTENT.description}</p>
	</div>
</div>
<!-- END: viewdescription -->
<!-- BEGIN: viewcatloop -->
<div class="col-md-{PER_LINE} col-lg-{PER_LINE} col-sm-12 col-xs-24 videos_list">
	<div class="thumbnail">
		<!-- BEGIN: image -->
		<a title="{CONTENT.title}" href="{CONTENT.link}"><img alt="{HOMEIMGALT1}" src="{HOMEIMG1}" style="width:{IMGWIDTH}px;height:{IMGHEIGHT}px;"  class="img-responsive video_img"/></a>
		<!-- END: image -->
		<h4><a class="show" href="{CONTENT.link}" title="{CONTENT.title}">{CONTENT.title_cut}</a></h4>
		<div class="text-muted">
			<ul class="list-unstyled">
				<li>{LANG.by}&nbsp;<a href="{CONTENT.uploader_link}" title="{CONTENT.uploader_name}">{CONTENT.uploader_name}</a></li>
				<li class="pull-left">{CONTENT.publtime}</li>
				<li class="spacer pull-left"></li>
				<li>{CONTENT.hitstotal}&nbsp;{LANG.hits_view}</li>
			</ul>
		</div>
		<p class="clear">{ADMINLINK}</p>
	</div>
</div>
<!-- END: viewcatloop -->
<div class="clear">&nbsp;</div>
<!-- BEGIN: generate_page -->
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->