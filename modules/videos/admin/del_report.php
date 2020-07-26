<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$rid = $nv_Request->get_int( 'rid', 'post', 0 );
$id = $nv_Request->get_int( 'id', 'post', 0 );
$checkss = $nv_Request->get_string( 'checkss', 'post' );

$contents = "NO_" . $rid;
$id = $db->query( "SELECT id FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows_report WHERE id=" . intval( $id ) )->fetchColumn();
if( $rid > 0 and $id > 0 and $checkss == md5( $rid . $id . session_id() . $global_config['sitekey'] ) )
{
	nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_rows_report', "id " . $id, $admin_info['userid'] );
	$query = "DELETE FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows_report WHERE rid=" . $rid . " AND id=" . $id;
	if( $db->exec( $query ) )
	{
		$nv_Cache->delMod( $module_name );
		$contents = "OK_" . $rid;
	}
}

if( defined( 'NV_IS_AJAX' ) )
{
	include NV_ROOTDIR . '/includes/header.php';
	echo $contents;
	include NV_ROOTDIR . '/includes/footer.php';
}
else
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=report' );
	die();
}