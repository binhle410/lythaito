<!-- BEGIN: main -->
<form name="block_list" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}&amp;playlist_id={PLAYLIST_ID}" method="get">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<colgroup>
				<col span="3" />
				<col class="w150" />
			</colgroup>
			<thead>
				<tr>
					<th class="text-center"><input name="check_all[]" type="checkbox" value="yes" onclick="nv_checkAll(this.form, 'idcheck[]', 'check_all[]',this.checked);" /></th>
					<th class="w100">{LANG.weight}</th>
					<th>{LANG.name}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5"><input class="btn btn-primary" type="button" onclick="nv_del_playlist_list(this.form, {PLAYLIST_ID})" value="{LANG.delete_from_playlist}"></td>
				</tr>
			</tfoot>
			<tbody>
			<!-- BEGIN: loop -->
				<tr>
					<td class="text-center"><input type="checkbox" onclick="nv_UncheckAll(this.form, 'idcheck[]', 'check_all[]', this.checked);" value="{ROW.id}" name="idcheck[]" /></td>
					<td class="text-center">
					<select class="form-control" id="id_playlist_sort_{ROW.id}" onchange="nv_change_playlist({PLAYLIST_ID},{ROW.id},'playlist_sort');">
						<!-- BEGIN: playlist_sort -->
						<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
						<!-- END: playlist_sort -->
					</select></td>
					<td class="text-left"><a target="_blank" href="{ROW.link}">{ROW.title}</a></td>
					<td class="text-center">
						<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}=content&amp;id={ROW.id}">{GLANG.edit}</a> 
					</td>
				</tr>
			<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: main -->
<!-- BEGIN: no_video -->
<div class="alert alert-info">{LANG.content_no_video}</div>
<!-- END: no_video -->