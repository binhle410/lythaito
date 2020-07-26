<!-- BEGIN: main -->
<div class="block_album_tab_new">
	<ul class="nav nav-tabs" role="tablist" id="block_album_tab_new_{BLOCK_ID}">
		<!-- BEGIN: tabs -->
		<li role="presentation">
			<a href="#{TABS.alias}" aria-controls="home" role="tab" data-toggle="tab">{TABS.name_cut}</a>
		</li>
		<!-- END: tabs -->
	</ul>

	<div class="tab-content">
		<!-- BEGIN: tabs_data -->
		<div role="tabpanel" class="tab-pane" id="{TABS.alias}" style="padding: 10px">
			<div class="row">
				<!-- BEGIN: loop -->
				<div class="col-xs-24 col-sm-6 col-md-6" style="margin-bottom: 7px">
					<a href="{DATA.link}" title="{DATA.name}"><img src="{DATA.thumb}" alt="{DATA.name}" class="img-thumbnail" /></a>
				</div>
				<!-- END: loop -->
			</div>
		</div>
		<!-- END: tabs_data -->
	</div>
</div>
<script>
$(window).load(function(){
	$('#block_album_tab_new_{BLOCK_ID} a:first').tab('show');
});
</script>
<!-- END: main -->