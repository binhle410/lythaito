<?php

/**
 * @Project NUKEVIET 4.x
 * @Author DANGDINHTU (dlinhvan@gmail.com)
 * @Copyright (C) 2013 Webdep24.com. All rights reserved
 * @Blog  http://dangdinhtu.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate  Wed, 21 Jan 2015 14:00:59 GMT
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$page_title = $lang_module['photo'];

function photo_fix_weight()
{
	global $db_slave;
	$sql = 'SELECT photo_id FROM ' . TABLE_SLIDER_NAME . '_photo ORDER BY weight ASC';
	$result = $db_slave->query( $sql );
	$weight = 0;
	while( $row = $result->fetch() )
	{
		++$weight;
		$db_slave->query( 'UPDATE ' . TABLE_SLIDER_NAME . '_photo SET weight=' . $weight . ' WHERE photo_id=' . $row['photo_id'] );
	}
	$result->closeCursor();
}

if( ACTION_METHOD == 'delete' )
{
	$json = array();

	$photo_id = $nv_Request->get_int( 'photo_id', 'post', 0 );

	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	$listid = $nv_Request->get_string( 'listid', 'post', '' );

	if( $listid != '' and md5( $nv_Request->session_id . $global_config['sitekey'] ) == $token )
	{
		$del_array = array_map( 'intval', explode( ',', $listid ) );
	}
	elseif( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $photo_id ) )
	{
		$del_array = array( $photo_id );
	}

	if( ! empty( $del_array ) )
	{

		$_del_array = array();

		$a = 0;
		foreach( $del_array as $photo_id )
		{

			$db_slave->query( 'DELETE FROM ' . TABLE_SLIDER_NAME . '_photo WHERE photo_id = ' . ( int )$photo_id );

			$json['id'][$a] = $photo_id;

			$_del_array[] = $photo_id;

			++$a;
		}

		$count = sizeof( $_del_array );

		if( $count )
		{
			photo_fix_weight();

			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_photo', implode( ', ', $_del_array ), $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['photo_delete_success'];
		}

	}
	else
	{
		$json['error'] = $lang_module['photo_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'status' )
{
	$json = array();

	$photo_id = $nv_Request->get_int( 'photo_id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	if( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $photo_id ) )
	{
		$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_photo SET status=' . $new_vid . ' WHERE photo_id=' . $photo_id;
		if( $db_slave->exec( $sql ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_change_status_photo', 'photo_id:' . $photo_id, $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['photo_status_success'];

		}
		else
		{
			$json['error'] = $lang_module['photo_error_status'];

		}
	}
	else
	{
		$json['error'] = $lang_module['photo_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'weight' )
{
	$json = array();

	$photo_id = $nv_Request->get_int( 'photo_id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	if( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $photo_id ) )
	{
		$sql = 'SELECT photo_id FROM ' . TABLE_SLIDER_NAME . '_photo WHERE photo_id!=' . $photo_id . ' ORDER BY weight ASC';
		$result = $db_slave->query( $sql );

		$weight = 0;
		while( $row = $result->fetch() )
		{
			++$weight;
			if( $weight == $new_vid ) ++$weight;
			$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_photo SET weight=' . $weight . ' WHERE photo_id=' . intval( $row['photo_id'] );
			$db_slave->query( $sql );
		}

		$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_photo SET weight=' . $new_vid . ' WHERE photo_id=' . $photo_id;
		if( $db_slave->exec( $sql ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_change_weight_photo', 'photo_id:' . $photo_id, $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['photo_weight_success'];
			$json['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

		}
		else
		{
			$json['error'] = $lang_module['photo_error_weight'];

		}
	}
	else
	{
		$json['error'] = $lang_module['photo_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'add' || ACTION_METHOD == 'edit' )
{
	$data['group_id'] = $nv_Request->get_int( 'group_id', 'get,post', 0 );
	
	$data = array(
		'photo_id' => 0,
		'group_id' => $data['group_id'],
		'title' => '',
		'weight' => '',
		'status' => 1,
		'date_added' => NV_CURRENTTIME );

	$error = array();

	$data['photo_id'] = $nv_Request->get_int( 'photo_id', 'get,post', 0 );
	if( $data['photo_id'] > 0 )
	{
		$data = $db_slave->query( 'SELECT *
		FROM ' . TABLE_SLIDER_NAME . '_photo  
		WHERE photo_id=' . $data['photo_id'] )->fetch();

		$caption = $lang_module['photo_edit'];
	}
	else
	{
		$caption = $lang_module['photo_add'];
	}

	if( $nv_Request->get_int( 'save', 'post' ) == 1 )
	{

		$data['photo_id'] = $nv_Request->get_int( 'photo_id', 'post', 0 );
		$data['group_id'] = $nv_Request->get_int( 'group_id', 'post', 0 );
		$data['status'] = $nv_Request->get_int( 'status', 'post', 0 );
		$data['title'] = nv_substr( $nv_Request->get_title( 'title', 'post', '', '' ), 0, 250 );
		$data['links'] = nv_substr( $nv_Request->get_title( 'links', 'post', '', '' ), 0, 250 );
		$data['description'] = $nv_Request->get_textarea('description', '', 'br', 1);
		$data['image'] = nv_substr( $nv_Request->get_title( 'image', 'post', '', '' ), 0, 250 );
	
		if( empty( $data['title'] ) )
		{
			$error['title'] = $lang_module['photo_error_title'];
		}
		if( empty( $data['image'] ) )
		{
			$error['image'] = $lang_module['photo_error_image'];
		}
		
		if( ! empty( $error ) && ! isset( $error['warning'] ) )
		{
			$error['warning'] = $lang_module['photo_error_warning'];
		}

		if( empty( $error ) )
		{
			
			$data['thumb'] = '';
			if( nv_is_url( $data['image'] ) )
			{
				 
				$data['image'] = $data['image'];
			}
			elseif( !empty( $data['image'] ) && is_file( NV_DOCUMENT_ROOT . $data['image'] ) )
			{
				$lu = strlen( NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' );
				$data['image'] = substr( $data['image'], $lu );
				
			}
			else
			{
				$data['image'] = '';
			}
				
			if( !empty( $data['image'] ) )
			{
				$width = 150;
				$height = 50;
				$image = NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/images/' . $data['image'];
				$imginfo = nv_is_image( $image );

				if( $width >= $height ) $rate = $width / $height;
				else  $rate = $height / $width;
				$basename = preg_replace( '/(.*)(\.[a-zA-Z]+)$/', '\1-thumb\2',  basename( $data['image'] ) );
		 
				$createImage = new NukeViet\Files\Image( $image, NV_MAX_WIDTH, NV_MAX_HEIGHT, 90 );
				if( $imginfo['width'] <= $imginfo['height'] )
				{
					$createImage->resizeXY( $width, 0 );

				}
				elseif( ( $imginfo['width'] / $imginfo['height'] ) < $rate )
				{
					$createImage->resizeXY( $width, 0 );
				}
				elseif( ( $imginfo['width'] / $imginfo['height'] ) >= $rate )
				{
					$createImage->resizeXY( 0, $height );
				}
				$createImage->cropFromCenter( $width, $height );
				$createImage->save( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_name . '/thumbs', $basename );
				$createImage->close();
 
				$data['thumb'] = $basename;
				
			}
		 
			if( $data['photo_id'] == 0 )
			{
				try
				{
					$stmt = $db_slave->prepare( 'SELECT MAX(weight) FROM ' . TABLE_SLIDER_NAME . '_photo' );
					$stmt->execute();
					$weight = $stmt->fetchColumn();

					$weight = intval( $weight ) + 1;

					$stmt = $db_slave->prepare( 'INSERT INTO ' . TABLE_SLIDER_NAME . '_photo SET 
						group_id = '. intval( $data['group_id'] ) .',
						weight = ' . intval( $weight ) . ', 
						date_added = ' . intval( $data['date_added'] ) . ',
						title =:title,
						links =:links,
						description =:description,
						image =:image,
						thumb =:thumb' );

					$stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR );
					$stmt->bindParam( ':links', $data['links'], PDO::PARAM_STR );
					$stmt->bindParam( ':description', $data['description'], PDO::PARAM_STR, strlen($data['description']));
        			$stmt->bindParam( ':image', $data['image'], PDO::PARAM_STR );
		    		$stmt->bindParam( ':thumb', $data['thumb'], PDO::PARAM_STR );
		    
					$stmt->execute();

					if( $data['photo_id'] = $db_slave->lastInsertId() )
					{
						
						$nv_Request->set_Session( $module_data . '_success', $lang_module['photo_insert_success'] );
						
						nv_insert_logs( NV_LANG_DATA, $module_name, 'Thêm ảnh', 'photo_id: ' . $data['photo_id'], $admin_info['userid'] );
						
						
					}
					else
					{
						$error['warning'] = $lang_module['photo_error_save'];

					}
					$stmt->closeCursor();

				}
				catch ( PDOException $e )
				{
					$error['warning'] = $lang_module['photo_error_save'];
					//var_dump($e);die();
				}

			}
			else
			{
				try
				{

					$stmt = $db_slave->prepare( 'UPDATE ' . TABLE_SLIDER_NAME . '_photo SET 
						group_id = '. intval( $data['group_id'] ) .',
						title =:title,
						links =:links,
						description =:description,
						image =:image,
						thumb =:thumb
						WHERE photo_id=' . $data['photo_id'] );

					$stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR );
					$stmt->bindParam( ':links', $data['links'], PDO::PARAM_STR );
					$stmt->bindParam( ':description', $data['description'], PDO::PARAM_STR, strlen($data['description']));
        			$stmt->bindParam( ':image', $data['image'], PDO::PARAM_STR );
		    		$stmt->bindParam( ':thumb', $data['thumb'], PDO::PARAM_STR );
					
					if( $stmt->execute() )
					{
						$nv_Request->set_Session( $module_data . '_success', $lang_module['photo_update_success'] );
						
						nv_insert_logs( NV_LANG_DATA, $module_name, 'Chỉnh sửa ảnh', 'photo_id: ' . $data['photo_id'], $admin_info['userid'] );
					}
					else
					{
						$error['warning'] = $lang_module['photo_error_save'];

					}

					$stmt->closeCursor();

				}
				catch ( PDOException $e )
				{
					$error['warning'] = $lang_module['photo_error_save'];
					//var_dump($e);
				}

			}

		}
		if( empty( $error ) )
		{
			$nv_Cache->delMod($module_name); 

			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&group_id=' . $data['group_id'] );
			die();
		}

	}
	
	if ( ! empty($data['image'] ) and file_exists( NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/images/' . $data['image']) ) {
		$data['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $data['image'];
	}
	$xtpl = new XTemplate( 'photo_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
	$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
	$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
	$xtpl->assign( 'THEME', $global_config['site_theme'] );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_FILE', $module_file );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'CAPTION', $caption );
	$xtpl->assign( 'DATA', $data );
	$xtpl->assign( 'CANCEL', NV_BASE_ADMINURL . "index.php?" . NV_LANG_VARIABLE . "=" . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . "=" . $module_name . "&" . NV_OP_VARIABLE . "=" . $op );
	$xtpl->assign( 'UPLOAD_CURRENT', NV_UPLOADS_DIR . '/' . $module_upload . '/images' );
	$xtpl->assign( 'UPLOAD_PATH', NV_UPLOADS_DIR . '/' . $module_upload );
	
	$result = $db->query( 'SELECT group_id, title FROM ' . TABLE_SLIDER_NAME . '_group ORDER BY weight ASC' );
	while( $rows = $result->fetch() )
	{
		$xtpl->assign( 'GROUP', array( 'key'=> $rows['group_id'], 'name'=> $rows['title'], 'selected'=> ( $rows['group_id'] == $data['group_id'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.group' );
	}
	
	if( isset( $error['warning'] ) )
	{
		$xtpl->assign( 'error_warning', $error['warning'] );
		$xtpl->parse( 'main.error_warning' );
	}

	if( isset( $error['title'] ) )
	{
		$xtpl->assign( 'error_title', $error['title'] );
		$xtpl->parse( 'main.error_title' );
	}
	if( isset( $error['image'] ) )
	{
		$xtpl->assign( 'error_image', $error['image'] );
		$xtpl->parse( 'main.error_image' );
	}

	foreach( $array_status as $key => $name )
	{
		$xtpl->assign( 'STATUS', array(
			'key' => $key,
			'name' => $name,
			'selected' => ( $key == $data['status'] ) ? 'selected="selected"' : '' ) );
		$xtpl->parse( 'main.status' );
	}

	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}

/*show list photo*/

$per_page = 50;

$page = $nv_Request->get_int( 'page', 'get', 1 );
$group_id = $nv_Request->get_int( 'group_id', 'get', 1 );

$sql = TABLE_SLIDER_NAME . '_photo WHERE 1';

if( $group_id )
{
	$sql.=' AND group_id = ' . intval( $group_id );
}

$sort = $nv_Request->get_string( 'sort', 'get', '' );

$order = $nv_Request->get_string( 'order', 'get' ) == 'desc' ? 'desc' : 'asc';

$sort_data = array(
	'title',
	'status',
	'weight' );

if( isset( $sort ) && in_array( $sort, $sort_data ) )
{

	$sql .= ' ORDER BY ' . $sort;
}
else
{
	$sql .= ' ORDER BY weight';
}

if( isset( $order ) && ( $order == 'desc' ) )
{
	$sql .= ' DESC';
}
else
{
	$sql .= ' ASC';
}
 
$num_items = $db_slave->query( 'SELECT COUNT(*) FROM ' . $sql )->fetchColumn();

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=photo&amp;sort=' . $sort . '&amp;order=' . $order . '&amp;per_page=' . $per_page;

$db_slave->sqlreset()->select( '*' )->from( $sql )->limit( $per_page )->offset( ( $page - 1 ) * $per_page );

$result = $db_slave->query( $db_slave->sql() );

$array = array();
while( $rows = $result->fetch() )
{
	$array[] = $rows;
}

$xtpl = new XTemplate( 'photo.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_LANG_VARIABLE', NV_LANG_VARIABLE );
$xtpl->assign( 'NV_LANG_DATA', NV_LANG_DATA );
$xtpl->assign( 'NV_BASE_SITEURL', NV_BASE_SITEURL );
$xtpl->assign( 'THEME', $global_config['site_theme'] );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
$xtpl->assign( 'MODULE_FILE', $module_file );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'TOKEN', md5( $nv_Request->session_id . $global_config['sitekey'] ) );
$xtpl->assign( 'ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=photo&action=add&group_id=' . $group_id );

$order2 = ( $order == 'asc' ) ? 'desc' : 'asc';

$xtpl->assign( 'URL_TITLE', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sort=title&amp;order=' . $order2 . '&amp;per_page=' . $per_page );
$xtpl->assign( 'URL_WEIGHT', NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;sort=weight&amp;order=' . $order2 . '&amp;per_page=' . $per_page );

$xtpl->assign( 'TITLE_ORDER', ( $sort == 'title' ) ? 'class="' . $order2 . '"' : '' );
$xtpl->assign( 'WEIGHT_ORDER', ( $sort == 'weight' ) ? 'class="' . $order2 . '"' : '' );


if( $nv_Request->get_string( $module_data . '_success', 'session' ) )
{
	$xtpl->assign( 'SUCCESS', $nv_Request->get_string( $module_data . '_success', 'session' ) );

	$xtpl->parse( 'main.success' );

	$nv_Request->unset_request( $module_data . '_success', 'session' );

}


if( ! empty( $array ) )
{
	foreach( $array as $item )
	{

		$item['token'] = md5( $nv_Request->session_id . $global_config['sitekey'] . $item['photo_id'] );
		$item['edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&action=edit&photo_id=' . $item['photo_id'] . '&token=' . $item['token'];
		$item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/images/' . $item['image'];
		$item['thumb'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/' . $item['thumb'];
		$xtpl->assign( 'LOOP', $item );

		for( $i = 1; $i <= $num_items; ++$i )
		{
			$xtpl->assign( 'WEIGHT', array(
				'key' => $i,
				'name' => $i,
				'selected' => ( $i == $item['weight'] ) ? ' selected="selected"' : '' ) );

			$xtpl->parse( 'main.loop.weight' );
		}
		 
		$xtpl->parse( 'main.loop' );
	}

}

$generate_page = nv_generate_page( $base_url, $num_items, $per_page, $page );
if( ! empty( $generate_page ) )
{
	$xtpl->assign( 'GENERATE_PAGE', $generate_page );
	$xtpl->parse( 'main.generate_page' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
