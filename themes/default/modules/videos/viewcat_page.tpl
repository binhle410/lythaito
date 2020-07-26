<!-- BEGIN: main -->
<!-- BEGIN: viewdescription -->
<div class="news_column">
	<div class="alert alert-info clearfix">
		<h1>{CONTENT.title}</h1>
		<!-- BEGIN: image -->
		<img alt="{CONTENT.title}" src="{HOMEIMG1}" width="{IMGWIDTH1}" class="img-responsive pull-left imghome" />
		<!-- END: image -->
		<p>{CONTENT.description}</p>
	</div>
</div>
<!-- END: viewdescription -->
<!-- BEGIN: viewcatloop -->
<div class="news_column">
	<!-- BEGIN: news -->
	<div class="panel panel-default">
		<div class="panel-body">
			<!-- BEGIN: image -->
			<div class="videos-thumbnail pull-left col-md-6 col-lg-6 col-xs-6">
				<a href="{CONTENT.link}" title="{CONTENT.title}"><img alt="{CONTENT.title}" src="{HOMEIMG1}" style="width:{IMGWIDTH}px;height:{IMGHEIGHT}px;" class="img-thumbnail imghome" /></a>
			</div>
			<!-- END: image -->
			<div class="videos-text col-md-18 col-lg-18 col-xs-18">
				<h3>
					<a href="{CONTENT.link}" title="{CONTENT.title}">{CONTENT.title_cut}</a>
				</h3>
				<div class="text-muted">
					<ul class="list-unstyled">
						<li>{LANG.by}&nbsp;<a href="{CONTENT.uploader_link}" title="{CONTENT.uploader_name}">{CONTENT.uploader_name}</a></li>
						<li class="pull-left">{CONTENT.publtime}</li>
						<!-- BEGIN: hitstotal -->
						<li class="spacer pull-left"></li>
						<li>{CONTENT.hitstotal}&nbsp;{LANG.hits_view}</li>
						<!-- END: hitstotal -->
					</ul>
				</div>
				<!-- BEGIN: adminlink -->
				<p class="text-right">
					{ADMINLINK}
				</p>
				
				<!-- END: adminlink -->
			</div>
		</div>
	</div>
	<!-- END: news -->
</div>
<!-- END: viewcatloop -->
<!-- BEGIN: generate_page -->
<div class="clearfix"></div>
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: main -->