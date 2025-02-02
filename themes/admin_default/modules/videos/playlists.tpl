<!-- BEGIN: main -->
<div id="module_show_list">
	{PLAYLIST_CAT_LIST}
</div>
<br />
<a id="edit"></a>
<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php" method="post">
	<input type="hidden" name ="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
	<input type="hidden" name ="{NV_OP_VARIABLE}" value="{OP}" />
	<input type="hidden" name ="playlist_id" value="{PLAYLIST_ID}" />
	<input name="savecat" type="hidden" value="1" />
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<caption><em class="fa fa-file-text-o">&nbsp;</em>{LANG.add_playlist}</caption>
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
						<span class="text-middle">{GLANG.length_characters}: <span id="titlelength" class="red">0</span>. {GLANG.title_suggest_max}</span>
						</td>
				</tr>
				<tr>
					<td class="text-right"><strong>{LANG.alias}: </strong></td>
					<td>
						<input class="form-control w500 pull-left" name="alias" id="idalias" type="text" value="{alias}" maxlength="255" /> 
						&nbsp; <span class="text-middle"><em class="fa fa-refresh fa-lg fa-pointer"onclick="get_alias('playlistcat', {PLAYLIST_ID});">&nbsp;</em></span>
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
					<td class="text-right"><strong>{LANG.playlist_status}: </strong></td>
					<td>
						<select class="form-control w200" name="status" id="status">
							<!-- BEGIN: status -->
							<option value="{STATUS.key}" {STATUS.selected}>{STATUS.title}</option>
							<!-- END: status -->
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-right"><strong>{LANG.keywords}: </strong></td>
					<td><input class="form-control w500" name="keywords" type="text" value="{keywords}" maxlength="255" /></td>
				</tr>
				<tr>
					<td class="text-right"><strong>{LANG.description}</strong></td>
					<td><textarea class="w500 form-control" id="description" name="description" cols="100" rows="5">{description}</textarea><span class="text-middle">{GLANG.length_characters}: <span id="descriptionlength" class="red">0</span>. {GLANG.description_suggest_max}</span></td>
				</tr>
				<tr>
					<td class="text-right"><strong>{LANG.content_homeimg}</strong></td>
					<td><input class="form-control w500 pull-left" style="margin-right: 5px" type="text" name="image" id="image" value="{image}"/> <input id="select-img-group" type="button" value="Browse server" name="selectimg" class="btn btn-info" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</form>
<script type="text/javascript">
var CFG = [];
CFG.upload_current = '{UPLOAD_CURRENT}';
$(document).ready(function(){
	$("#titlelength").html($("#idtitle").val().length);
	$("#idtitle").bind("keyup paste", function() {
		$("#titlelength").html($(this).val().length);
	});

	$("#descriptionlength").html($("#description").val().length);
	$("#description").bind("keyup paste", function() {
		$("#descriptionlength").html($(this).val().length);
	});
	<!-- BEGIN: getalias -->
	$("#idtitle").change(function() {
		get_alias("playlistcat", '{PLAYLIST_ID}');
	});
	<!-- END: getalias -->
});
</script>
<!-- END: main -->