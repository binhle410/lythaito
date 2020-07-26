<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<colgroup>
			<col class="w80">
			<col class="w350">
			<col class="w120">
			<col class="w90">
			<col class="w90">
		</colgroup>
		<thead>
			<tr>
				<th>{LANG.weight}</th>
				<th>{LANG.name}</th>
				<td class="text-center">{LANG.playlist_status}</th>
				<td class="text-center">{LANG.playlist_public}</th>
				<td class="text-center" >{LANG.numlinks}</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr <!-- BEGIN: pending -->class="warning"<!-- END: pending --><!-- BEGIN: disable -->class="danger"<!-- END: disable -->>
				<td class="text-center">
				<select class="form-control" id="id_weight_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','weight');">
					<!-- BEGIN: weight -->
					<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
					<!-- END: weight -->
				</select></td>
				<td><a href="{ROW.link}">{ROW.title}</a> (<a href="{ROW.linksite}" target="_blank">{ROW.numnews}&nbsp;{LANG.playlist_num_news}&nbsp;<i class="fa fa-external-link"></i></a>)</td>
				<td class="text-center">
					<select class="form-control" id="id_status_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','status');">
						<!-- BEGIN: status -->
						<option value="{STATUS.key}"{STATUS.selected}>{STATUS.title}</option>
						<!-- END: status -->
					</select>
				</td>
				
				<td class="text-center">
					<select class="form-control" id="id_private_mode_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','private_mode');">
						<!-- BEGIN: private_mode -->
						<option value="{PRIVATE_MODE.key}"{PRIVATE_MODE.selected}>{PRIVATE_MODE.title}</option>
						<!-- END: private_mode -->
					</select>
				</td>
				<td class="text-center">
				<select class="form-control" id="id_numlinks_{ROW.playlist_id}" onchange="nv_change_playlist_cat('{ROW.playlist_id}','numlinks');">
					<!-- BEGIN: number -->
					<option value="{NUMBER.key}"{NUMBER.selected}>{NUMBER.title}</option>
					<!-- END: number -->
				</select></td>
				<td class="text-center">
					<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_playlist_cat({ROW.playlist_id})">{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
	<!-- BEGIN: generate_page -->
	<div class="center-block col-md-24" align="center">
	{GENERATE_PAGE}
	</div>
	<!-- END: generate_page -->
</div>
<script>
var curr_page = "{CUR_PAGE}";
</script>
<!-- END: main -->