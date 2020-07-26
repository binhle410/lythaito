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

$page_title = $lang_module['group'];

function group_fix_weight()
{
	global $db_slave;
	$sql = 'SELECT group_id FROM ' . TABLE_SLIDER_NAME . '_group ORDER BY weight ASC';
	$result = $db_slave->query( $sql );
	$weight = 0;
	while( $row = $result->fetch() )
	{
		++$weight;
		$db_slave->query( 'UPDATE ' . TABLE_SLIDER_NAME . '_group SET weight=' . $weight . ' WHERE group_id=' . $row['group_id'] );
	}
	$result->closeCursor();
}

if( ACTION_METHOD == 'delete' )
{
	$json = array();

	$group_id = $nv_Request->get_int( 'group_id', 'post', 0 );

	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	$listid = $nv_Request->get_string( 'listid', 'post', '' );

	if( $listid != '' and md5( $nv_Request->session_id . $global_config['sitekey'] ) == $token )
	{
		$del_array = array_map( 'intval', explode( ',', $listid ) );
	}
	elseif( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $group_id ) )
	{
		$del_array = array( $group_id );
	}

	if( ! empty( $del_array ) )
	{

		$_del_array = array();

		$a = 0;
		foreach( $del_array as $group_id )
		{

			if( $rows_total = $db_slave->query( 'SELECT COUNT(*) FROM ' . TABLE_SLIDER_NAME . '_photo WHERE group_id = ' . ( int )$group_id )->fetchColumn() )
			{
				$json['error'] = sprintf( $lang_module['group_error_photo'], $rows_total );
			}
			else
			{
				$db_slave->query( 'DELETE FROM ' . TABLE_SLIDER_NAME . '_group WHERE group_id = ' . ( int )$group_id );

				$json['id'][$a] = $group_id;

				$_del_array[] = $group_id;

				++$a;
			}
		}

		$count = sizeof( $_del_array );

		if( $count )
		{
			group_fix_weight();

			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_del_group', implode( ', ', $_del_array ), $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['group_delete_success'];
		}

	}
	else
	{
		$json['error'] = $lang_module['group_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'status' )
{
	$json = array();

	$group_id = $nv_Request->get_int( 'group_id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	if( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $group_id ) )
	{
		$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_group SET status=' . $new_vid . ' WHERE group_id=' . $group_id;
		if( $db_slave->exec( $sql ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_change_status_group', 'group_id:' . $group_id, $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['group_status_success'];

		}
		else
		{
			$json['error'] = $lang_module['group_error_status'];

		}
	}
	else
	{
		$json['error'] = $lang_module['group_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'weight' )
{
	$json = array();

	$group_id = $nv_Request->get_int( 'group_id', 'post', 0 );
	$new_vid = $nv_Request->get_int( 'new_vid', 'post', 0 );
	$token = $nv_Request->get_title( 'token', 'post', '', 1 );

	if( $token == md5( $nv_Request->session_id . $global_config['sitekey'] . $group_id ) )
	{
		$sql = 'SELECT group_id FROM ' . TABLE_SLIDER_NAME . '_group WHERE group_id!=' . $group_id . ' ORDER BY weight ASC';
		$result = $db_slave->query( $sql );

		$weight = 0;
		while( $row = $result->fetch() )
		{
			++$weight;
			if( $weight == $new_vid ) ++$weight;
			$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_group SET weight=' . $weight . ' WHERE group_id=' . intval( $row['group_id'] );
			$db_slave->query( $sql );
		}

		$sql = 'UPDATE ' . TABLE_SLIDER_NAME . '_group SET weight=' . $new_vid . ' WHERE group_id=' . $group_id;
		if( $db_slave->exec( $sql ) )
		{
			nv_insert_logs( NV_LANG_DATA, $module_name, 'log_change_weight_group', 'group_id:' . $group_id, $admin_info['userid'] );

			$nv_Cache->delMod($module_name);

			$json['success'] = $lang_module['group_weight_success'];
			$json['link'] = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op;

		}
		else
		{
			$json['error'] = $lang_module['group_error_weight'];

		}
	}
	else
	{
		$json['error'] = $lang_module['group_error_security'];
	}

	echo get_output_json( $json );
}
elseif( ACTION_METHOD == 'add' || ACTION_METHOD == 'edit' )
{

	$data = array(
		'group_id' => 0,
		'title' => '',
		'weight' => '',
		'date_added' => NV_CURRENTTIME );

	$error = array();

	$data['group_id'] = $nv_Request->get_int( 'group_id', 'get,post', 0 );
	if( $data['group_id'] > 0 )
	{
		$data = $db_slave->query( 'SELECT *
		FROM ' . TABLE_SLIDER_NAME . '_group  
		WHERE group_id=' . $data['group_id'] )->fetch();

		$caption = $lang_module['group_edit'];
	}
	else
	{
		$caption = $lang_module['group_add'];
	}

	if( $nv_Request->get_int( 'save', 'post' ) == 1 )
	{

		$data['group_id'] = $nv_Request->get_int( 'group_id', 'post', 0 );
		$data['title'] = nv_substr( $nv_Request->get_title( 'title', 'post', '', '' ), 0, 255 );

		if( empty( $data['title'] ) )
		{
			$error['title'] = $lang_module['group_error_title'];
		}
		
		if( ! empty( $error ) && ! isset( $error['warning'] ) )
		{
			$error['warning'] = $lang_module['group_error_warning'];
		}

		if( empty( $error ) )
		{
			if( $data['group_id'] == 0 )
			{
				try
				{
					$stmt = $db_slave->prepare( 'SELECT MAX(weight) FROM ' . TABLE_SLIDER_NAME . '_group' );
					$stmt->execute();
					$weight = $stmt->fetchColumn();

					$weight = intval( $weight ) + 1;

					$stmt = $db_slave->prepare( 'INSERT INTO ' . TABLE_SLIDER_NAME . '_group SET 
						weight = ' . intval( $weight ) . ', 
						date_added = ' . intval( $data['date_added'] ) . ', 
						title =:title' );

					$stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR );
					$stmt->execute();

					if( $data['group_id'] = $db_slave->lastInsertId() )
					{
						
						$nv_Request->set_Session( $module_data . '_success', $lang_module['group_insert_success'] );
						
						nv_insert_logs( NV_LANG_DATA, $module_name, 'Thêm nhóm', 'group_id: ' . $data['group_id'], $admin_info['userid'] );
						
						
					}
					else
					{
						$error['warning'] = $lang_module['group_error_save'];

					}
					$stmt->closeCursor();

				}
				catch ( PDOException $e )
				{
					$error['warning'] = $lang_module['group_error_save'];
					//var_dump($e);die();
				}

			}
			else
			{
				try
				{

					$stmt = $db_slave->prepare( 'UPDATE ' . TABLE_SLIDER_NAME . '_group SET 
						title =:title 
						WHERE group_id=' . $data['group_id'] );

					$stmt->bindParam( ':title', $data['title'], PDO::PARAM_STR );
					if( $stmt->execute() )
					{
						$nv_Request->set_Session( $module_data . '_success', $lang_module['group_update_success'] );
						
						nv_insert_logs( NV_LANG_DATA, $module_name, 'edit group', 'group_id: ' . $data['group_id'], $admin_info['userid'] );
					}
					else
					{
						$error['warning'] = $lang_module['group_error_save'];

					}

					$stmt->closeCursor();

				}
				catch ( PDOException $e )
				{
					$error['warning'] = $lang_module['group_error_save'];
					//var_dump($e);
				}

			}

		}
		if( empty( $error ) )
		{
			$nv_Cache->delMod($module_name); 

			Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op );
			die();
		}

	}

	$xtpl = new XTemplate( 'group_add.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
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
 

	$xtpl->parse( 'main' );
	$contents = $xtpl->text( 'main' );

	include NV_ROOTDIR . '/includes/header.php';
	echo nv_admin_theme( $contents );
	include NV_ROOTDIR . '/includes/footer.php';
}

/*show list group*/

$per_page = 50;

$page = $nv_Request->get_int( 'page', 'get', 1 );

$sql = TABLE_SLIDER_NAME . '_group WHERE 1';


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

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=group&amp;sort=' . $sort . '&amp;order=' . $order . '&amp;per_page=' . $per_page;

$db_slave->sqlreset()->select( '*' )->from( $sql )->limit( $per_page )->offset( ( $page - 1 ) * $per_page );

$result = $db_slave->query( $db_slave->sql() );

$array = array();
while( $rows = $result->fetch() )
{
	$array[] = $rows;
}

$xtpl = new XTemplate( 'group.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
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
$xtpl->assign( 'ADD_NEW', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . "&" . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=group&action=add' );

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

		$item['token'] = md5( $nv_Request->session_id . $global_config['sitekey'] . $item['group_id'] );
		$item['edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op . '&action=edit&group_id=' . $item['group_id'] . '&token=' . $item['token'];
		$item['add'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=photo&action=add&group_id=' . $item['group_id'] . '&token=' . $item['token'];
		$item['view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=photo&action=view&group_id=' . $item['group_id'] . '&token=' . $item['token'];

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
