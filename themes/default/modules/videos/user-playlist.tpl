<!-- BEGIN: mainrefresh -->
<div class="text-center">
	{DATA.content}
	<br />
	<br />
	<img src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/images/load_bar.gif" />
	<br />
	<br />
</div>
<meta http-equiv="refresh" content="5;URL={DATA.urlrefresh}" />
<!-- END: mainrefresh -->

<!-- BEGIN: main -->
<div class="row">
	<div id="module_show_playlist" class="col-md-24">
		{PLAYLIST_CAT_LIST}
	</div>
	<br/>
	<a id="edit"></a>
	<!-- BEGIN: error -->
	<div class="alert alert-warning">{ERROR}</div>
	<!-- END: error -->
	<!-- BEGIN: edit_playlist -->
	<div class="col-md-24">
		<form class="form-horizontal" action="{NV_BASE_SITEURL}index.php" method="post">
			<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
			<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
			<input type="hidden" name ="playlist_id" value="{PLAYLIST_ID}" />
			<input name="savecat" type="hidden" value="1" />
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.add_playlist_cat}</caption>
					<tfoot>
						<tr>
							<td class="text-center" colspan="2"><input class="btn btn-primary" name="submit1" type="submit" value="{LANG.save}" /></td>
						</tr>
					</tfoot>
					<tbody>
						<tr>
							<td class="text-right"><strong>{LANG.name}: </strong><sup class="required">(∗)</sup></td>
							<td>
								<input class="form-control w500" name="title" id="idtitle" type="text" value="{title}" maxlength="255" />
							</td>
						</tr>
						<tr>
							<td class="text-right"><strong>{LANG.alias}: </strong></td>
							<td>
								<input class="form-control form_80 pull-left" name="alias" id="idalias" type="text" value="{alias}" maxlength="255" /> 
								&nbsp; <span class="text-middle"><em class="fa fa-refresh fa-lg fa-pointer" onclick="get_alias('{OP_VIDEO}');">&nbsp;</em></span>
							</td>
						</tr>
						<tr>
							<td class="text-right"><strong>{LANG.playlist_public}: </strong></td>
							<td>
								<select class="form-control w200" name="private_mode" id="private_mode">
									<!-- BEGIN: private_mode -->
									<option value="{PRIVATE_MODE.key}" {PRIVATE_MODE.selected}>{PRIVATE_MODE.title}</option>
									<!-- END: private_mode -->
								</select>
							</td>
						</tr>
						<tr>
							<td class="text-right"><strong>{LANG.keywords}: </strong></td>
							<td><input class="form-control w500" name="keywords" type="text" value="{keywords}" maxlength="255" /></td>
						</tr>
						<tr>
							<td class="text-right"><strong>{LANG.description}</strong></td>
							<td><textarea class="w500 form-control" id="description" name="description" cols="100" rows="5">{description}</textarea></td>
						</tr>
						<tr>
							<td class="text-right"><strong>{LANG.content_homeimg}</strong></td>
							<td><input class="form-control w500 pull-left" style="margin-right: 5px" type="text" name="image" id="image" placeholder="{LANG.playlist_your_hotlink}" value="{image}" {disabled}/></td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
	<!-- END: edit_playlist -->
	<!-- BEGIN: userpl_disable -->
	<div class="col-md-24 alert alert-info">
	{LANG.userpl_disable}
	</div>
	<!-- END: userpl_disable -->
</div>
<script type="text/javascript">
<!-- BEGIN: getalias -->
$("#idtitle").change(function() {
	get_alias('{OP_VIDEO}');
});
<!-- END: getalias -->
</script>
<script type="text/javascript">
$("#del_playlist").click(function(event){
    if(!confirm ('Are you sure ?'))
       event.preventDefault();
});
</script>
<!-- END: main -->
<!-- BEGIN: playlist_single -->
<div id="module_show_list">
	{PLAYLIST_LIST}
</div>
<!-- BEGIN: news -->
<div id="add">
	<form class="form-inline" role="form" action="{NV_BASE_ADMINURL}index.php" method="post">
		<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="w50 text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
						<th>{LANG.name}</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></td>
						<td>
						<select class="form-control" name="playlist_id">
							<!-- BEGIN: playlist_id -->
							<option value="{PLAYLIST_ID.key}"{PLAYLIST_ID.selected}>{PLAYLIST_ID.title}</option>
							<!-- END: playlist_id -->
						</select>
						<input type="hidden" name ="checkss" value="{CHECKSESS}" /><input class="btn btn-primary" name="submit1" type="submit" value="{LANG.save}" /></td>
					</tr>
				</tfoot>
				<tbody>
					<!-- BEGIN: loop -->
					<tr>
						<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]"{ROW.checked}/></td>
						<td>{ROW.title}</td>
					</tr>
					<!-- END: loop -->
				</tbody>
			</table>
		</div>
	</form>
</div>
<!-- END: news -->
<!-- END: playlist_single -->