<!-- BEGIN: main_info -->
<ul class="nav nav-tabs uploader">
  <li class="active"><a href="#">{LANG.basic_uploader}</a></li>
  <li><a href="{UPLOADER.uploader_list}">{LANG.video_show_list}&nbsp;({UPLOADER.num_video}) </a></li>
  <!-- BEGIN: edit_link -->
  <li><a href="{UPLOADER.uploader_editinfo}">{LANG.uploader_editinfo}</a></li>
  <!-- END: edit_link -->
</ul>
<div class="page panel panel-default uploader_info">
	<div class="panel-body">
		<div class="row">
			<figure class="avatar left">
				<div style="width:80px;">
				<img src="{UPLOADER.uploader_gravatar}" alt="{UPLOADER.uploader_name}" title="{UPLOADER.uploader_name}" class="img-thumbnail bg-gainsboro m-bottom">
				</div>
			</figure>
			<div>
        		<ul class="nv-list-item xsm">
        			<li><strong>{UPLOADER.uploader_name}</strong></li>
					<!-- BEGIN: view_mail -->
        			<li>{GLANG.email} : {UPLOADER.email}</li>
					<!-- END: view_mail -->
        		</ul>
        	</div>
			<!-- BEGIN: description -->
			<div class="well clear">
				<p>{UPLOADER.description}</p>
			</div>
			<!-- END: description -->
		</div>
	</div>
	<p><h4 class="pull-left">{LANG.latest_uploader}</h4></p>
	<hr class="clear"/>
	<div class="panel-body">
		<div class="row">
			<!-- BEGIN: loop -->
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-24 videos_list">
				<!-- BEGIN: image -->
					<a class="clearfix" title="{ITEM.title}" href="{ITEM.link}">
						<img src="{HOMEIMG}" alt="{HOMEIMGALT}" class="imghome img-responsive" />
					</a>
				<!-- END: image -->
					<h3>
						<a title="{ITEM.title}" href="{ITEM.link}">{ITEM.title_cut}</a>
					</h3>
					<div class="text-muted">
						<ul class="list-unstyled">
							<li>{LANG.by}&nbsp;<a href="{ITEM.uploader_link}" title="{ITEM.uploader_name}">{ITEM.uploader_name}</a></li>
							<li class="pull-left">{ITEM.publtime}</li>
							<!-- BEGIN: hitstotal -->
							<li class="spacer pull-left"></li>
							<li>{ITEM.hitstotal}&nbsp;{LANG.hits_view}</li>
							<!-- END: hitstotal -->
						</ul>
					</div>
			</div>
		<!-- END: loop -->
		</div>
	</div>
	<!-- BEGIN: generate_page -->
	<div class="clearfix"></div>
	<div class="text-center">
		{GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
</div>
<!-- END: main_info -->

<!-- BEGIN: list_video -->
<ul class="nav nav-tabs uploader">
  <li><a href="{UPLOADER.link}">{LANG.basic_uploader}</a></li>
  <li class="active"><a href="#">{LANG.video_show_list}&nbsp;({UPLOADER.num_video}) </a></li>
  <!-- BEGIN: edit_link -->
  <li><a href="{UPLOADER.uploader_editinfo}">{LANG.uploader_editinfo}</a></li>
  <!-- END: edit_link -->
</ul>
<div class="page panel panel-default uploader_info">
	<div class="panel-body">
		<div class="row">
			<!-- BEGIN: loop -->
			<div class="col-md-6 col-lg-6 col-sm-12 col-xs-24 videos_list">
				<!-- BEGIN: image -->
					<a class="clearfix" title="{ITEM.title}" href="{ITEM.link}">
						<img src="{HOMEIMG}" alt="{HOMEIMGALT}" class="imghome img-responsive" />
					</a>
				<!-- END: image -->
					<h3>
						<a title="{ITEM.title}" href="{ITEM.link}">{ITEM.title_cut}</a>
					</h3>
					<div class="text-muted">
						<ul class="list-unstyled">
							<li>{LANG.by}&nbsp;<a href="{ITEM.uploader_link}" title="{ITEM.uploader_name}">{ITEM.uploader_name}</a></li>
							<li class="pull-left">{ITEM.publtime}</li>
							<!-- BEGIN: hitstotal -->
							<li class="spacer pull-left"></li>
							<li>{ITEM.hitstotal}&nbsp;{LANG.hits_view}</li>
							<!-- END: hitstotal -->
						</ul>
					</div>
			</div>
			<!-- END: loop -->
		</div>
	</div>
</div>
<!-- BEGIN: generate_page -->
<div class="clearfix"></div>
<div class="text-center">
	{GENERATE_PAGE}
</div>
<!-- END: generate_page -->
<!-- END: list_video -->

<!-- BEGIN: edit_info -->
<ul class="nav nav-tabs">
  <li><a href="{UPLOADER.link}">{LANG.basic_uploader}</a></li>
 <li><a href="{UPLOADER.uploader_list}">{LANG.video_show_list}&nbsp;({UPLOADER.num_video}) </a></li>
  <li class="active"><a href="#">{LANG.uploader_editinfo}</a></li>
</ul>
<div class="panel-body">
	<form action="{UPLOADER.uploader_editinfo}" method="post" role="form" class="form-horizontal" autocomplete="off">
		<div class="form-detail">
			<div class="form-group">
				<label for="first_name" class="control-label col-md-6 text-normal">{LANG.first_name}</label>
				<div class="col-md-12">
					<input type="text" class="form-control" placeholder="{LANG.first_name}" value="{UPLOADER.first_name}" name="first_name" maxlength="255" style="width: 250px;">
				</div>
			</div>

			<div class="form-group">
				<label for="last_name" class="control-label col-md-6 text-normal">{LANG.last_name}</label>
				<div class="col-md-12">
					<input type="text" class="form-control" placeholder="{LANG.last_name}" value="{UPLOADER.last_name}" name="last_name" maxlength="255" style="width: 250px;">
				</div>
			</div>

			<div class="form-group">
				<label for="uploader_description" class="control-label col-md-6 text-normal">{LANG.uploader_description}</label>
				<div class="col-md-4">
					<textarea type="text" class="form-control" placeholder="{LANG.uploader_description}" name="uploader_description" style="width: 250px;">{UPLOADER.description}</textarea>
					</div>
			</div>
			
			<div class="form-group">
				<label for="view_mail" class="control-label col-md-6 text-normal">{LANG.showmail}</label>
				<div class="col-md-4">
					<select name="view_mail" class="form-control">
						<option value="0">{GLANG.no}</option>
						<option value="1"{UPLOADER.show_mail}>{GLANG.yes}</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-6 col-sm-6 control-label">{LANG.captcha} <span class="txtrequired">(*)</span></label>
				<div class="col-md-10 col-sm-4">
					<input type="text" maxlength="6" value="" id="fcode" name="fcode" class="form-control pull-left" style="width: 150px;" required/><img height="30" src="{NV_BASE_SITEURL}index.php?scaptcha=captcha&t={NV_CURRENTTIME}" alt="{LANG.captcha}" class="captchaImg" /><i class="fa fa-refresh refresh" aria-hidden="true" onclick="change_captcha('#fcode_iavim');" ></i>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-6">
					<input type="hidden" name="checkss" value="{UPLOADER.checkss}" />
					<input type="hidden" value="1" name="save" />
					<input type="hidden" value="{UPLOADER.userid}" name="userid" />
				</div>
				<div class="col-md-10">
					<a class="btn btn-warning" href="{UPLOADER.uploader_editinfo}" title="{GLANG.cancel}"><span>{GLANG.cancel}</span></a>
					<input type="submit" class="btn btn-primary" value="{LANG.editinfo_confirm}" />
				</div>
			</div>
		</div>
	</form>
</div>

<!-- END: edit_info -->