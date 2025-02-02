<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );
if( ! defined( 'NV_IS_AJAX' ) ) die( 'Wrong URL' );

$contents = '';
$array_point = array( 1, 2, 3, 4, 5 );

$id = $nv_Request->get_int( 'id', 'post', 0 );
$point = $nv_Request->get_int( 'point', 'post', 0 );
$checkss = $nv_Request->get_title( 'checkss', 'post' );

$time_set = $nv_Request->get_int( $module_name . '_' . $op . '_' . $id, 'session', 0 );

if( $id > 0 and in_array( $point, $array_point ) and $checkss == md5( $id . $client_info['session_id'] . $global_config['sitekey'] ) )
{
	if( ! empty( $time_set ) )
	{
		die( $lang_module['rating_error2'] );
	}

	$nv_Request->set_Session( $module_name . '_' . $op . '_' . $id, NV_CURRENTTIME );
	$query = $db->query( "SELECT listcatid, allowed_rating, total_rating, click_rating FROM " . NV_PREFIXLANG . "_" . $module_data . "_rows WHERE id = " . $id . " AND status=1" );
	$row = $query->fetch();
	if( isset( $row['allowed_rating'] ) and $row['allowed_rating'] == 1 )
	{
		$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_rows SET total_rating=total_rating+" . $point . ", click_rating=click_rating+1 WHERE id=" . $id;
		$db->query( $query );
		$array_catid = explode( ',', $row['listcatid'] );
		foreach( $array_catid as $catid_i )
		{
			$query = "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_" . $catid_i . " SET total_rating=total_rating+" . $point . ", click_rating=click_rating+1 WHERE id=" . $id;
			$db->query( $query );
		}
		$contents = sprintf( $lang_module['stringrating'], $row['total_rating'] + $point, $row['click_rating'] + 1 );
		die( $contents );
	}
}

die( $lang_module['rating_error1'] );