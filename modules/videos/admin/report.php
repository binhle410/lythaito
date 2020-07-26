<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-9-2010 14:43
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );


$page_title = $lang_module['videos_reports'];

$xtpl = new XTemplate( 'report.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );

$page = $nv_Request->get_int( 'page', 'get', 1 );
$per_page = 20;
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

$num = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report' )->fetchColumn();
if( $num > 0 )
{
	$array_reports = array(
		1 => $lang_module['report_notplay'],
		2 => $lang_module['report_content'],
		3 => $lang_module['report_copyright'],
		4 => $lang_module['report_other']
	);

	$ae = 0;
	$sql = 'SELECT t1.rid, t1.id, t2.title, t2.alias, t2.catid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_rows t2 ON t1.id=t2.id LIMIT ' . ( $page - 1 ) * $per_page . ',' . $per_page ;

	$result = $db->query( $sql );
	while( $data = $result->fetch( ) )
	{
		foreach ( $array_reports as $value => $report){
			if ( $data['rid'] == $value){
				$data['report'] = $report;
			}
		}
		$data['checkss'] = md5( $data['rid'] . $data['id'] . session_id() . $global_config['sitekey'] );
		$data['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$data['catid']]['alias'] . '/' . $data['alias'] . '-' . $data['id'] . $global_config['rewrite_exturl'];
		$data['edit_link'] = NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&amp;" . NV_NAME_VARIABLE . "=" . $module_name . "&amp;" . NV_OP_VARIABLE . "=content&amp;id=" . $data['id'];
		++$ae;
		$data['num'] = $ae;
		$data['delete'] = "<em class=\"fa fa-trash-o fa-lg\">&nbsp;</em> <a href=\"javascript:void(0);\" onclick=\"nv_del_report('" . $data['rid'] . "', '" . $data['id'] . "', '" . $data['checkss'] . "')\">" . $lang_module['report_del'] . "</a>";
		$data['edit'] = '<em class="fa fa-edit margin-right">&nbsp;</em> <a href="' . $data['edit_link'] . '">' . $lang_module['content_edit'] . '</a>';
		$xtpl->assign( 'ROW', $data );
		$xtpl->parse( 'list.data.row' );
	}
	
	$generate_page = nv_generate_page( $base_url, $num, $per_page, $page );
	if( ! empty( $generate_page ) )
	{
		$xtpl->assign( 'GENERATE_PAGE', $generate_page );
		$xtpl->parse( 'list.data.generate_page' );
	}
	$xtpl->parse( 'list.data' );
}
else
{
	$xtpl->parse( 'list.empty' );
}

$xtpl->parse( 'list' );
$contents = $xtpl->text( 'list' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';