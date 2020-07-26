<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );
$page_title = $lang_module['playlists'];

$error = '';
$savecat = 0;
list( $playlist_id, $title, $alias, $description, $image, $keywords, $status, $private_mode ) = array( 0, '', '', '', '', '', 1, 1 );

$savecat = $nv_Request->get_int( 'savecat', 'post', 0 );
if( ! empty( $savecat ) )
{
	$playlist_id = $nv_Request->get_int( 'playlist_id', 'post', 0 );
	$title = $nv_Request->get_title( 'title', 'post', '', 1 );
	$keywords = $nv_Request->get_title( 'keywords', 'post', '', 1 );
	$alias = $nv_Request->get_title( 'alias', 'post', '' );
	$description = $nv_Request->get_string( 'description', 'post', '' );
	$description = nv_nl2br( nv_htmlspecialchars( strip_tags( $description ) ), '<br/>' );
	$alias = ( $alias == '' ) ? change_alias( $title ) : change_alias( $alias );
	$status = $nv_Request->get_int( 'status', 'post', 0 );
	$private_mode = $nv_Request->get_int( 'private_mode', 'post', 0 );

	$image = $nv_Request->get_string( 'image', 'post', '' );
	if( is_file( NV_DOCUMENT_ROOT . $image ) )
	{	
		$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' );
		$image = substr( $image, $lu );
	}
	else
	{
		$image = '';
	}

	if( empty( $title ) )
	{
		$error = $lang_module['error_name'];
	}
	elseif( $playlist_id == 0 )
	{
		$weight = $db->query( "SELECT max(weight) FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlist_cat" )->fetchColumn();
		$weight = intval( $weight ) + 1;

		$sql = "INSERT INTO " . NV_PREFIXLANG . "_" . $module_data . "_playlist_cat ( numbers, title, alias, status, private_mode, userid, description, image, weight, keywords, add_time, edit_time) VALUES (20, :title , :alias, :status, :private_mode, :userid, :description, :image, :weight, :keywords, " . NV_CURRENTTIME . ", " . NV_CURRENTTIME . ")";
		$data_insert = array();
		$data_insert['title'] = $title;
		$data_insert['alias'] = $alias;
		$data_insert['status'] = $status;
		$data_insert['private_mode'] = $private_mode;
		$data_insert['userid'] = $admin_info['userid'];
		$data_insert['image'] = $image;
		$data_insert['description'] = $description;
		$data_insert['weight'] = $weight;
		$data_insert['keywords'] = $keywords;

		if( $db->insert_id( $sql, 'playlist_id', $data_insert ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_add_playlistcat', " ", $admin_info['userid'] );
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}
		else
		{
			$error = $lang_module['errorsave'];
		}
	}
	else
	{
		$stmt = $db->prepare( "UPDATE " . NV_PREFIXLANG . "_" . $module_data . "_playlist_cat SET title= :title, alias = :alias, status = :status, private_mode = :private_mode, description= :description, image= :image, keywords= :keywords, edit_time=" . NV_CURRENTTIME . " WHERE playlist_id =" . $playlist_id );
		$stmt->bindParam( ':title', $title, PDO::PARAM_STR );
		$stmt->bindParam( ':alias', $alias, PDO::PARAM_STR );
		$stmt->bindParam( ':status', $status, PDO::PARAM_STR );
		$stmt->bindParam( ':private_mode', $private_mode, PDO::PARAM_STR );
		$stmt->bindParam( ':description', $description, PDO::PARAM_STR );
		$stmt->bindParam( ':image', $image, PDO::PARAM_STR );
		$stmt->bindParam( ':keywords', $keywords, PDO::PARAM_STR );
		$stmt->execute();
		if( $stmt->execute() )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_edit_playlistcat', "playlist_id " . $playlist_id, $admin_info['userid'] );
			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}
		else
		{
			$error = $lang_module['errorsave'];
		}
	}
}

$array_status = array(
	$lang_global['no'],
	$lang_global['yes'],
	$lang_module['playlist_waiting_approve']
);

$array_private_mode = array(
	$lang_module['playlist_private_off'],
	$lang_module['playlist_private_on']
);
		
$playlist_id = $nv_Request->get_int( 'playlist_id', 'get', 0 );
if( $playlist_id > 0 )
{
	list( $playlist_id, $title, $alias, $description, $image, $keywords, $status, $private_mode ) = $db->query( "SELECT playlist_id, title, alias, description, image, keywords, status, private_mode FROM " . NV_PREFIXLANG . "_" . $module_data . "_playlist_cat where playlist_id=" . $playlist_id )->fetch( 3 );
$lang_module['add_playlist'] = $lang_module['edit_playlist'];
}

$lang_global['title_suggest_max'] = sprintf( $lang_global['length_suggest_max'], 65 );
$lang_global['description_suggest_max'] = sprintf( $lang_global['length_suggest_max'], 160 );

$xtpl = new XTemplate( 'playlists.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'GLANG', $lang_global );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );
$page = 1;
$xtpl->assign( 'PLAYLIST_CAT_LIST', nv_show_playlist_cat_list($page) );

$xtpl->assign( 'PLAYLIST_ID', $playlist_id );
$xtpl->assign( 'title', $title );
$xtpl->assign( 'alias', $alias );
$xtpl->assign( 'keywords', $keywords );
$xtpl->assign( 'description', nv_htmlspecialchars( nv_br2nl( $description ) ) );

if( ! empty( $image ) and file_exists( NV_UPLOADS_REAL_DIR . "/" . $module_upload . "/img/" . $image ) )
{
	$image = NV_BASE_SITEURL . NV_UPLOADS_DIR . "/" . $module_upload . "/img/" . $image;
}
$xtpl->assign( 'image', $image );
$xtpl->assign( 'UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload  . "/img/playlists/" );

foreach( $array_status as $key => $val )
{
	$xtpl->assign( 'STATUS', array(
		'key' => $key,
		'title' => $val,
		'selected' => $key == $status ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.status' );
}

foreach( $array_private_mode as $key => $val )
{
	$xtpl->assign( 'PRIVATE_MODE', array(
		'key' => $key,
		'title' => $val,
		'selected' => $key == $private_mode ? ' selected="selected"' : ''
	) );
	$xtpl->parse( 'main.private_mode' );
}
			
if( ! empty( $error ) )
{
	$xtpl->assign( 'ERROR', $error );
	$xtpl->parse( 'main.error' );
}

if( empty( $alias ) )
{
	$xtpl->parse( 'main.getalias' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';