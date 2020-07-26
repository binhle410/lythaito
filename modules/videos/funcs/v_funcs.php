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
require NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

$mod = $nv_Request->get_title( 'mod_list', 'get,post', '', 1 );
$fcheck_session = $nv_Request->get_title( 'fcheck', 'get,post', '' );
if( $mod == 'get_fav'){
	$id = $nv_Request->get_int( 'id', 'get', 0 );
	$contents = nv_get_videos_favourite( $id );
	include NV_ROOTDIR . '/includes/header.php';
	echo $contents;
	include NV_ROOTDIR . '/includes/footer.php';
}elseif( $mod == 'report' ){
	$id = $nv_Request->get_int( 'id', 'post', 0 );
	$rid = $nv_Request->get_int( 'rid', 'post', 0 );
	$newscheckss = $nv_Request->get_title( 'newscheckss', 'post', '' );
	$contents = nv_get_videos_report( $id, $rid, $newscheckss );
	include NV_ROOTDIR . '/includes/header.php';
	echo $contents;
	include NV_ROOTDIR . '/includes/footer.php';
}

if( defined( 'NV_IS_USER' ) ){
	if( $fcheck_session == md5( $user_info['userid'] . $global_config['sitekey'] . session_id() ) ){
		if( $mod == 'playlist'){
			$playlist_id = $nv_Request->get_int( 'playlist_id', 'get', 0 );
			$contents = nv_show_playlist_list( $playlist_id );
			include NV_ROOTDIR . '/includes/header.php';
			echo $contents;
			include NV_ROOTDIR . '/includes/footer.php';
		}elseif($mod == 'playlist_cat' ){
			$contents = nv_show_playlist_cat_list();
			include NV_ROOTDIR . '/includes/header.php';
			echo $contents;
			include NV_ROOTDIR . '/includes/footer.php';
		}elseif($mod == 'user_playlist' ){
			$id = $nv_Request->get_int( 'id', 'get', 0 );
			$contents = nv_get_user_playlist( $id );
			include NV_ROOTDIR . '/includes/header.php';
			echo $contents;
			include NV_ROOTDIR . '/includes/footer.php';
		}elseif( $mod == 'fav'){
			$id = $nv_Request->get_int( 'id', 'post', 0 );
			$newscheckss = $nv_Request->get_title( 'newscheckss', 'post', '' );
			$contents = nv_favourite_videos( $id, $newscheckss );
			include NV_ROOTDIR . '/includes/header.php';
			echo $contents;
			include NV_ROOTDIR . '/includes/footer.php';
		}
	}
}