<!-- BEGIN: list -->
<!-- BEGIN: empty -->
<div class="alert alert-info">{LANG.videos_noreport}</div>
<!-- END: empty -->
<!-- BEGIN: data -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="col-md-3">{LANG.part_row_title} Số thứ tự </th>
				<th class="col-md-5">{LANG.part_row_title} Tên Video</th>
				<th class="col-md-5">{LANG.part_row_title} Nội dung báo lỗi</th>
				<th class="col-md-5">   </th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: row -->
			<tr>
				<td>{ROW.num}</td>
				<td><a href="{ROW.link}" title="{ROW.title}">{ROW.title}&nbsp;<i class="fa fa-external-link-square">&nbsp;</i></a></td>
				<td>{ROW.report}</td>
				<td align="center">{ROW.edit} - {ROW.delete}</td>
			</tr>
			<!-- END: row -->
		</tbody>
	</table>
</div>
<!-- BEGIN: generate_page -->
	<div class="text-center">{GENERATE_PAGE}</div>
<!-- END: generate_page -->
<!-- END: data -->
<!-- END: list -->