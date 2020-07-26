<!-- BEGIN: main -->
<div id="photo-content">
   <!-- BEGIN: error_warning -->
    <div class="alert alert-danger">
        <i class="fa fa-exclamation-circle"></i> {error_warning}<i class="fa fa-times"></i>           
    </div>
    <!-- END: error_warning -->
    <div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" style="float:left"><i class="fa fa-pencil"></i> {CAPTION}</h3>
			<div class="pull-right">
				<button type="submit" form="form-stock" data-toggle="tooltip" class="btn btn-primary" title="{LANG.save}"><i class="fa fa-save"></i></button> 
				<a href="{CANCEL}" data-toggle="tooltip" class="btn btn-default" title="{LANG.cancel}"><i class="fa fa-reply"></i></a>
			</div>
			<div style="clear:both"></div>
		</div>
		<div class="panel-body">
			<form action="" method="post"  enctype="multipart/form-data" id="form-photo" class="form-horizontal">
				<input type="hidden" name ="photo_id" value="{DATA.photo_id}" />
				<input name="save" type="hidden" value="1" />
 
				<div class="form-group required">
					<label class="col-sm-4 control-label" for="input-title">{LANG.photo_title}</label>
					<div class="col-sm-20">
						<input type="text" name="title" value="{DATA.title}" placeholder="{LANG.photo_title}" id="input-title" class="form-control" />
						<!-- BEGIN: error_title --><div class="text-danger">{error_title}</div><!-- END: error_title -->
					</div>
				</div>
				<div class="form-group required">
					<label class="col-sm-4 control-label" for="input-group">{LANG.photo_group}</label>
					<div class="col-sm-20">
						<select name="group_id" id="input-group" class="form-control">
							<!-- BEGIN: group -->
							<option value="{GROUP.key}" {GROUP.selected}>{GROUP.name}</option>
							<!-- END: group -->
						</select>
					</div>
				</div>
				<div class="form-group">
                    <label class="col-sm-4 control-label" for="image">{LANG.photo_image} </label>
                    <div class="col-sm-20">
						<div class="input-group">
							<input class="form-control" type="text" name="image" id="image" value="{DATA.image}" placeholder="{LANG.photo_image}"  />
							<span class="input-group-btn" >
								<input type="button" value="{LANG.select_image}" name="selectimg" class="btn btn-primary"  />
							</span>
						</div>
						<!-- BEGIN: error_image --><div class="text-danger">{error_image}</div><!-- END: error_image -->
					
                    </div>
                </div> 		                  	 	                  	 					
				<div class="form-group">
					<label class="col-sm-4 control-label" for="input-links">{LANG.photo_links}</label>
					<div class="col-sm-20">
						<input type="text" name="links" value="{DATA.links}" placeholder="{LANG.photo_links}" id="input-links" class="form-control" />
					</div>
				</div> 		                  	 
    			<div class="form-group">
					<label class="col-sm-4 control-label" for="input-description">{LANG.photo_description}</label>
					<div class="col-sm-20">
						 <textarea name="description" rows="5" col="3" id="input-description" placeholder="{LANG.photo_description}" class="form-control">{DATA.description}</textarea>
						 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label" for="input-status">{LANG.photo_status}</label>
					<div class="col-sm-20">
						<select name="status" id="input-status" class="form-control">
							<!-- BEGIN: status -->
							<option value="{STATUS.key}" {STATUS.selected}>{STATUS.name}</option>
							<!-- END: status -->
						</select>
					</div>
				</div>	
				<div align="center">
					<input class="btn btn-primary" type="submit" value="{LANG.save}">
					<a class="btn btn-primary" href="{CANCEL}" title="{LANG.cancel}">{LANG.cancel}</a> 
				</div>          
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$("input[name=selectimg]").click(function() {
	var area = "image";
	var path = "{UPLOAD_PATH}";
	var currentpath = "{UPLOAD_CURRENT}";
	var type = "image";
	nv_open_browse(script_name + "?" + nv_name_variable + "=upload&popup=1&area=" + area + "&path=" + path + "&type=" + type + "&currentpath=" + currentpath, "NVImg", 850, 420, "resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
	return false;
});
</script>
<!-- END: main -->