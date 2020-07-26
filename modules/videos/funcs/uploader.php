<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

$mode = '';
$uploader_alias = $array_op[1];
if( isset( $array_op[1] ) AND !isset( $array_op[2] )){
	$mode = 'uploader';
}
elseif( isset( $array_op[2] ) AND (sizeof( $array_op ) == 3) AND ( $array_op[2] == 'list' OR $array_op[2] == 'editinfo' ) )
{
	$mode = $array_op[2];
}elseif( isset( $array_op[3] ) ){
	if( (sizeof( $array_op ) == 4) AND (preg_match( '/^page\-([0-9]+)$/', $array_op[3], $m )) AND ($array_op[2] == 'list' ) )
	{
		$mode = $array_op[2];
		$page = intval( $m[1] );
	}
	else
	{
		$uploader_alias = '';
	}
}

$uploader_id = '';
$db->sqlreset()
	->select( 'userid' )
	->from( NV_PREFIXLANG . '_' . $module_data . '_uploaders' )
	->where( 'username = ' . $db->quote( $uploader_alias ). ' AND md5username=' .  $db->quote( nv_md5safe($uploader_alias) ) );
	$result = $db->query( $db->sql() );
	$uploader_id = $result->fetchColumn();
	$u_info = $global_array_uploader[$uploader_id];
	$checkss = md5( $u_info['userid'] . $client_info['session_id'] . $global_config['sitekey'] );
	$u_info['checkss'] = $checkss;
	
	$item_array = array();
	$end_publtime = 0;
	$uploader_alias = $db->dblikeescape( nv_htmlspecialchars( $uploader_alias ) );

	$db->sqlreset()
		->select( 'COUNT(*)' )
		->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )
		->where( 'status=1 AND admin_id=' . $u_info['userid'] );
	
	$num_items = $db->query( $db->sql() )->fetchColumn();
	$u_info['num_video'] = $num_items;
	if( $u_info['view_mail'] == 1 ){
		$u_info['show_mail'] = 'selected="selected"';
	}
	
	$description = $num_items . $lang_module['playlist_num_news'];
	$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['uploader']. '/' . $uploader_alias . '/list';
	$show_no_image = $module_config[$module_name]['show_no_image'];
	
	$about_title = $u_info['uploader_name'];
	$uploadpage_title = $lang_module['uploaded_by'] . ' ' . $u_info['uploader_name'];
	$editinfo_title = $lang_module['uploader_editinfo'] . ' ' . $u_info['uploader_name'];
	
if( empty($show_no_image) )
{
	$show_no_image = 'themes/default/images/' . $module_name . '/' . 'video_placeholder.png';
}

if ( $mode == 'uploader'){
	if($num_items > 0)
	{
		$db->select( 'id, catid, admin_id, admin_name, author, artist, sourceid, addtime, edittime, publtime, title, alias, hometext, homeimgfile, homeimgalt, homeimgthumb, allowed_rating, hitstotal, hitscm, total_rating, click_rating' )
			->order( 'publtime DESC' )
			->limit( $per_page )
			->offset( ( $page - 1 ) * $per_page );

		$result = $db->query( $db->sql() );
		while( $item = $result->fetch() )
		{
			if( $item['homeimgthumb'] == 1 OR $item['homeimgthumb'] == 2 ) //image file
			{
				$item['imghome'] = videos_thumbs($item['id'], $item['homeimgfile'], $module_upload, $module_config[$module_name]['homewidth'], $module_config[$module_name]['homeheight'], 90 );
			}
			elseif( $item['homeimgthumb'] == 3 ) //image url
			{
				$item['imghome'] = $item['homeimgfile'];
			}
			elseif( ! empty( $show_no_image ) )//no image
			{
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['imghome'] = '';
			}
			$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
			$item['width'] = $module_config[$module_name]['homewidth'];

			$end_publtime = $item['publtime'];
			$item['uploader_name'] = $global_array_uploader[$u_info['userid']]['uploader_name'];
			$item['uploader_link'] = $global_array_uploader[$u_info['userid']]['link'];

			$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$item['title_cut'] = nv_clean60( $item['title'], $module_config[$module_name]['titlecut'], true );
			$item_array[] = $item;
		}
		$result->closeCursor();
		unset( $query, $item );
		$generate_page = nv_alias_page( $uploadpage_title, $base_url, $num_items, $per_page, $page );
		$contents = uploader_theme( $u_info, $item_array, $generate_page, $mode );
	}
	$page_title = $u_info['uploader_name'] . ' | ' . $lang_module['basic_uploader'];
	$array_mod_title[] = array(
		'catid' => 0,
		'title' => $u_info['uploader_name'],
		'link' => $global_array_uploader[$uploader_id]['link']
	);
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}elseif( !empty( $uploader_id ) AND $mode == 'list' )
{
	$page_title = $uploadpage_title;

	$array_mod_title[] = array(
		'catid' => 0,
		'title' => $about_title,
		'link' => $global_array_uploader[$uploader_id]['link']
	);
	
	$array_mod_title[] = array(
		'catid' => 1,
		'title' => $uploadpage_title,
		'link' => $global_array_uploader[$uploader_id]['uploader_list']
	);
	
	if($num_items > 0)
	{
		$db->select( 'id, catid, admin_id, admin_name, author, artist, sourceid, addtime, edittime, publtime, title, alias, hometext, homeimgfile, homeimgalt, homeimgthumb, allowed_rating, hitstotal, hitscm, total_rating, click_rating' )
			->order( 'publtime DESC' )
			->limit( $per_page )
			->offset( ( $page - 1 ) * $per_page );

		$result = $db->query( $db->sql() );
		while( $item = $result->fetch() )
		{
			if( $item['homeimgthumb'] == 1 OR $item['homeimgthumb'] == 2 ) //image file
			{
				$item['imghome'] = videos_thumbs($item['id'], $item['homeimgfile'], $module_upload, $module_config[$module_name]['homewidth'], $module_config[$module_name]['homeheight'], 90 );
			}
			elseif( $item['homeimgthumb'] == 3 ) //image url
			{
				$item['imghome'] = $item['homeimgfile'];
			}
			elseif( ! empty( $show_no_image ) )//no image
			{
				$item['imghome'] = NV_BASE_SITEURL . $show_no_image;
			}
			else
			{
				$item['imghome'] = '';
			}
			$item['alt'] = ! empty( $item['homeimgalt'] ) ? $item['homeimgalt'] : $item['title'];
			$item['width'] = $module_config[$module_name]['homewidth'];

			$end_publtime = $item['publtime'];
			$item['uploader_name'] = $global_array_uploader[$u_info['userid']]['uploader_name'];
			$item['uploader_link'] = $global_array_uploader[$u_info['userid']]['link'];

			$item['link'] = $global_array_cat[$item['catid']]['link'] . '/' . $item['alias'] . '-' . $item['id'] . $global_config['rewrite_exturl'];
			$item['title_cut'] = nv_clean60( $item['title'], $module_config[$module_name]['titlecut'], true );
			$item_array[] = $item;
		}
		$result->closeCursor();
		unset( $query, $item );
		
		if( $page > 1 )
		{
			$page_title .= ' ' . NV_TITLEBAR_DEFIS . ' ' . $lang_global['page'] . ' ' . $page;
		}

		$generate_page = nv_alias_page( $page_title, $base_url, $num_items, $per_page, $page );
		$contents = uploader_theme( $u_info, $item_array, $generate_page, $mode );
	}

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}elseif( !empty( $uploader_alias ) AND $mode == 'editinfo' ){
	if( defined( 'NV_IS_USER' ) AND $user_info['userid'] == $uploader_id)
	{
		$edit_info = array();
		$error = '';
		$fcheckss = $nv_Request->get_title('checkss', 'get,post', '');
		if( $nv_Request->get_int( 'save', 'post' ) == 1 )
		{
			$edit_info['userid'] = $nv_Request->get_int('userid', 'post', 0);
			$edit_info['first_name'] = $nv_Request->get_title('first_name', 'post', '', 1);
			$edit_info['last_name'] = $nv_Request->get_title('last_name', 'post', '', 1);
			$edit_info['uploader_description'] = $nv_Request->get_string('uploader_description', 'post', '', 1);
			$edit_info['view_mail'] = $nv_Request->get_int('view_mail', 'post', 0);
			$edit_info['fcode'] = $nv_Request->get_title( 'fcode', 'post', '' );

			if( empty($edit_info['first_name']) AND empty($edit_info['last_name']) ){
				$edit_info['first_name'] = $u_info['username'];
			}

			if( ! nv_capcha_txt( $edit_info['fcode'] ) )
			{
				$error = $lang_module['error_captcha'];
			}

			if( empty($error) ){
				if( $fcheckss == $u_info['checkss'] AND $user_info['userid'] == $u_info['userid']){

					$sth = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_uploaders SET
							 view_mail=' . intval( $edit_info['view_mail'] ) . ',
							 first_name=:first_name,
							 last_name=:last_name,
							 description=:description
						WHERE userid =' . intval( $edit_info['userid'] ) );

					$sth->bindParam(':first_name', $edit_info['first_name'], PDO::PARAM_STR);
					$sth->bindParam(':last_name', $edit_info['last_name'], PDO::PARAM_STR);
					$sth->bindParam(':description', $edit_info['uploader_description'], PDO::PARAM_STR, strlen($edit_info['uploader_description']));

					if ($sth->execute()) {
						nv_insert_logs(NV_LANG_DATA, $module_name, $lang_module['uploader_editinfo'], $user_info['username'], $user_info['userid']);
						$nv_Cache->delMod( $module_name );
						
						Header('Location: ' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['uploader']. '/' . $uploader_alias, true ) );
						die();
					}
				}
			}
		}
		
		if( ! empty( $error ) )
		{
			$my_head .= "<script type=\"text/javascript\">\n";
			$my_head .= "	alert('" . $error . "')\n";
			$my_head .= "</script>\n";
		}
		
		$page_title = $editinfo_title;
		$array_mod_title[] = array(
			'catid' => 0,
			'title' => $about_title,
			'link' => $global_array_uploader[$uploader_id]['link']
		);

		$array_mod_title[] = array(
			'catid' => 1,
			'title' => $editinfo_title,
			'link' => $global_array_uploader[$uploader_id]['uploader_editinfo']
		);

		unset($item_array);
		$generate_page = $item_array = '';
		$contents = uploader_theme( $u_info, $item_array, $generate_page, $mode );
	}else{
		// Not allow edit info
		$contents = "Khong co quyen thuc thi !";
	}
	
	include NV_ROOTDIR . '/includes/header.php';
	echo nv_site_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}

$redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true ) . '" />';
nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect, 404);