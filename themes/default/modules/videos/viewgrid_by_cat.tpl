<!-- BEGIN: main -->
<!-- BEGIN: listcat -->
<div class="news_column">
	<div class="panel panel-default clearfix">
		<div class="panel-heading">
			<ul class="list-inline sub-list-icon" style="margin: 0">
				<li><h4><a title="{CAT.title}" href="{CAT.link}"><span>{CAT.title}</span></a></h4></li>
				<!-- BEGIN: subcatloop -->
				<li class="hidden-xs"><h4><a class="dimgray" title="{SUBCAT.title}" href="{SUBCAT.link}">{SUBCAT.title}</a></h4></li>
				<!-- END: subcatloop -->
				<!-- BEGIN: subcatmore -->
				<li class="pull-right hidden-xs"><h4><a class="dimgray" title="{MORE.title}" href="{MORE.link}"><em class="fa fa-sign-out"></em></a></h4></li>
				<!-- END: subcatmore -->
			</ul>
		</div>
		<div class="panel-body">
			<div class="row">
				<!-- BEGIN: loop -->
				<div class="col-md-{PER_LINE} col-lg-{PER_LINE} col-sm-12 col-xs-24 videos_list">
					<!-- BEGIN: image -->
					<div class="videos-home-thumbnail pull-left col-md-24 col-lg-24 col-xs-24">
						<a class="clearfix" title="{CONTENT.title}" href="{CONTENT.link}">
							<img src="{HOMEIMG}" alt="{HOMEIMGALT}" class="imghome img-responsive" />
						</a>
					</div>
					<!-- END: image -->
					<div class="videos-home-info pull-left col-md-24 col-lg-24 col-xs-24">
						<h3 class="clearfix">
							<a title="{CONTENT.title}" href="{CONTENT.link}">{CONTENT.title_cut}</a>
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
					</div>
				</div>
			<!-- END: loop -->
			</div>
		</div>
	</div>
</div>
<!-- END: listcat -->
<!-- END: main -->