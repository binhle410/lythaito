<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );
if( ! defined( 'NV_IS_MOD_VIDEOS' ) ) die( 'Stop!!!' );

/**
 * nv_show_playlist_cat_list()
 *
 * @return
 */
function nv_show_playlist_cat_list()
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $module_config, $global_config, $module_info, $user_info;

	$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat WHERE userid='. $user_info['userid'] .' ORDER BY weight ASC';
	$_array_block_cat = $db->query( $sql )->fetchAll();
	$num = sizeof( $_array_block_cat );

	if( $num > 0 )
	{
		$array_status = array(
			$lang_global['no'],
			$lang_global['yes']
		);
		
		$array_share_mode = array(
			$lang_module['playlist_private_off'],
			$lang_module['playlist_private_on']
		);
		$xtpl = new XTemplate( 'playlist_cat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
		$xtpl->assign( 'LANG', $lang_module );
		$xtpl->assign( 'GLANG', $lang_global );
		
		$n = 1;
		foreach ( $_array_block_cat as $row)
		{
			$numnews = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $row['playlist_id'] )->fetchColumn();
			$xtpl->assign( 'ROW', array(
				'playlist_id' => $row['playlist_id'],
				'title' => $row['title'],
				'numnews' => $numnews,
				'no' => $n++,
				'check_session' => md5( $user_info['userid'] . $global_config['sitekey'] . session_id() ),
				'link' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' .  NV_OP_VARIABLE . '=' .$module_info['alias']['user-playlist'] . '/' . $row['alias'] .'-'. $row['playlist_id'], true),
				'linksite' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['playlists'] . '/' . $row['alias'], true),
				'url_edit' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['user-playlist'] . '&amp;playlist_id=' . $row['playlist_id'] . '&mode=edit#edit', true),
				'url_delete' => nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['user-playlist'] . '&amp;playlist_id=' . $row['playlist_id'] . '&mode=delete', true)
			) );

			foreach( $array_share_mode as $key => $val )
			{
				$xtpl->assign( 'PRIVATE_MODE', array(
					'key' => $key,
					'title' => $val,
					'selected' => $key == $row['private_mode'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'playlistcat_lists.loop.private_mode' );
			}
			
			foreach( $array_status as $key => $val )
			{
				$xtpl->assign( 'STATUS', array(
					'key' => $key,
					'title' => $val,
					'selected' => $key == $row['status'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'playlistcat_lists.loop.status' );
			}

			for( $i = 1; $i <= 30; ++$i )
			{
				$xtpl->assign( 'NUMBER', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $row['numbers'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'playlistcat_lists.loop.number' );
			}
			
			if($row['status'] == 2)
			{
				$xtpl->parse( 'playlistcat_lists.loop.pl_moderate' );
			}
			elseif($row['status'] == 0)
			{
				$xtpl->parse( 'playlistcat_lists.loop.pl_disallow' );
			}
			
			if($module_config[$module_name]['playlist_allow_detele'] > 0)
			{
				$xtpl->parse( 'playlistcat_lists.loop.delete' );
			}
			
			if( $module_config[$module_name]['allow_user_plist'] == 1 )
			{
				$xtpl->parse( 'playlistcat_lists.loop.edit_link' );
				$xtpl->parse( 'playlistcat_lists.loop.edit_btn' );
			}
			else
			{
				$xtpl->parse( 'playlistcat_lists.loop.title_only' );
			}

			$xtpl->parse( 'playlistcat_lists.loop' );
		}

		$xtpl->parse( 'playlistcat_lists' );
		$contents = $xtpl->text( 'playlistcat_lists' );
	}
	else
	{
		$contents = '&nbsp;';
	}

	return $contents;
}

function nv_show_playlist_list( $playlist_id )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $global_array_cat, $module_file, $module_config, $global_config, $user_info;

	$xtpl = new XTemplate( 'playlist_list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'PLAYLIST_ID', $playlist_id );
	$global_array_cat[0] = array( 'alias' => 'Other' );

	$sql = 'SELECT t1.id, t1.catid, t1.title, t1.alias, t2.playlist_sort FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows t1 INNER JOIN ' . NV_PREFIXLANG . '_' . $module_data . '_playlist t2 ON t1.id = t2.id WHERE t2.playlist_id= ' . $playlist_id . ' AND t1.status=1 ORDER BY t2.playlist_sort ASC';
	$array_block = $db->query( $sql )->fetchAll();

	$num = sizeof( $array_block );
	if( $num > 0 )
	{
		foreach ($array_block as $row)
		{
			$xtpl->assign( 'ROW', array(
				'id' => $row['id'],
				'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $global_array_cat[$row['catid']]['alias'] . '/' . $row['alias'] . '-' . $row['id'] . $global_config['rewrite_exturl'],
				'check_session' => md5( $user_info['userid'] . $global_config['sitekey'] . session_id() ),
				'title' => $row['title']
			) );

			for( $i = 1; $i <= $num; ++$i )
			{
				$xtpl->assign( 'WEIGHT', array(
					'key' => $i,
					'title' => $i,
					'selected' => $i == $row['playlist_sort'] ? ' selected="selected"' : ''
				) );
				$xtpl->parse( 'list_videos.loop.playlist_sort' );
			}
			$xtpl->parse( 'list_videos.loop' );
		}

		$xtpl->parse( 'list_videos' );
		$contents = $xtpl->text( 'list_videos' );
	}
	else
	{
		$xtpl->parse( 'no_videos' );
		$contents = $xtpl->text( 'no_videos' );
	}
	return $contents;
}

function nv_fix_playlist_cat()
{
	global $db, $module_data;
	$sql = 'SELECT playlist_id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat ORDER BY weight ASC';
	$result = $db->query( $sql );
	$weight = 0;
	while( $row = $result->fetch() )
	{
		++$weight;
		$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat SET weight=' . $weight . ' WHERE playlist_id=' . intval( $row['playlist_id'] );
		$db->query( $sql );
	}
	$result->closeCursor();
}


/**
 * nv_fix_playlist()
 *
 * @param mixed $playlist_id
 * @param bool $repairtable
 * @return
 */
function nv_fix_playlist( $playlist_id, $repairtable = true )
{
	global $db, $module_data;
	$playlist_id = intval( $playlist_id );
	if( $playlist_id > 0 )
	{
		$sql = 'SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $playlist_id . ' ORDER BY playlist_sort ASC';
		$result = $db->query( $sql );
		$playlist_sort = 0;
		while( $row = $result->fetch() )
		{
			++$playlist_sort;
			if( $playlist_sort <= 100 )
			{
				$sql = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist SET playlist_sort=' . $playlist_sort . ' WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
			}
			else
			{
				$sql = 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist WHERE playlist_id=' . $playlist_id . ' AND id=' . $row['id'];
			}
			$db->query( $sql );
		}
		$result->closeCursor();
		if( $repairtable )
		{
			$db->query( 'OPTIMIZE TABLE ' . NV_PREFIXLANG . '_' . $module_data . '_playlist' );
		}
	}
}

function nv_get_user_playlist( $id )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $module_config, $global_config, $module_info, $user_info;
	$xtpl = new XTemplate( 'playlist_cat.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );
	$xtpl->assign( 'USERLIST_OPS',  $module_info['alias']['user-playlist'] );
	$check_session = md5( $user_info['userid'] . $global_config['sitekey'] . session_id() );
	$xtpl->assign( 'check_session', $check_session );

	$array_user_playlist = array();
	// call user playlist
	if( defined( 'NV_IS_USER' ) AND isset( $user_info['userid']) AND $user_info['userid'] > 0)
	{
		$sql = 'SELECT playlist_id, title, status FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist_cat WHERE userid=' . $user_info['userid'] . ' AND status > 0 ORDER BY weight ASC';
		$array_user_playlist = $db->query( $sql )->fetchAll();
		if( !empty($array_user_playlist)){
			foreach($array_user_playlist as $array_user_playlist_i)
			{
				$array_user_playlist_i['id'] = $id;
				$array_user_playlist_i['numnews'] = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_playlist where playlist_id=' . $array_user_playlist_i['playlist_id'] )->fetchColumn();
				if( $array_user_playlist_i['status'] == 2 )
				{
					$array_user_playlist_i['disabled'] = 'disabled=disabled';
				}
				$xtpl->assign( 'USER_PLAYLIST', $array_user_playlist_i );
				$xtpl->parse( 'get_user_playlist.loop' );
			}
		}
	}
	$xtpl->parse( 'get_user_playlist' );
	$contents = $xtpl->text( 'get_user_playlist' );
	return $contents;
}

function nv_get_videos_favourite( $id )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $op, $module_file, $module_config, $global_config, $module_info, $user_info;
	$xtpl = new XTemplate( 'fav_report.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
	$xtpl->assign( 'GLANG', $lang_global );
	$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
	$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
	$xtpl->assign( 'NV_OP_VARIABLE', NV_OP_VARIABLE );
	$xtpl->assign( 'MODULE_NAME', $module_name );
	$xtpl->assign( 'OP', $op );

	$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_favourite WHERE id=' . $id;
	$count_Fav = $db->query( $sql )->fetchColumn();
	$xtpl->assign( 'FAVO', $count_Fav );
	unset($sql);

	if( defined( 'NV_IS_USER' ) )
	{
		$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_favourite WHERE id=' . $id . ' AND fid=' . $user_info['userid'];
		$count_FavUser = $db->query( $sql )->fetchColumn();
		if( $count_FavUser > 0){
			$lang_module['video_favorite'] = $lang_module['video_favorited'];
		}
	}
	$xtpl->assign( 'LANG', $lang_module );
	$xtpl->parse( 'videos_favourite_get' );
	$contents = $xtpl->text( 'videos_favourite_get' );
	return $contents;
}


function nv_favourite_videos( $id, $check_session )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $nv_Cache, $module_file, $module_config, $global_config, $module_info, $user_info;
	if ( $id > 0 ){
		if( defined( 'NV_IS_USER' ) )
		{
			$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_favourite WHERE id=' . $id . ' AND fid=' . $user_info['userid'];
			$count_FavUser = $db->query( $sql )->fetchColumn();
			if( $count_FavUser > 0){
				return 'OK_' . $lang_module['video_favorite_duplicate'];
			}else{
				if( $check_session == md5( $id . session_id() . $global_config['sitekey'] ) ){
					$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows_favourite VALUES(
					:fid,
					:id)'
					);
					$stmt->bindParam(':id', intval( $id ), PDO::PARAM_STR);
					$stmt->bindParam(':fid', intval( $user_info['userid'] ), PDO::PARAM_STR);
					if( $stmt->execute() )
					{
						$nv_Cache->delMod( $module_name );
						return 'OK_' . $lang_module['video_favorite_checked'] . '_' . $id . '_' . $check_session;
					}
				}
			}
		}
	}else{
		return 'OK_' . $lang_module['error_wrongid'];
	}
}

function nv_get_videos_report( $id, $rid, $check_session )
{
	global $db, $lang_module, $lang_global, $module_name, $module_data, $nv_Cache, $module_file, $module_config, $global_config, $module_info, $user_info;
	$array_rid = array(1,2,3,4);
	if ( $id > 0 AND in_array( $rid, $array_rid) ){
		$sql = 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report WHERE id=' . $id;
		$count_FavUser = $db->query( $sql )->fetchColumn();
		if( $count_FavUser > 0){
			if( $check_session == md5( $id . session_id() . $global_config['sitekey'] ) ){
				$sth = $db->prepare( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report SET rid = :rid WHERE id = ' . $id );
				$sth->bindValue( ':rid', intval( $rid ), PDO::PARAM_STR );
				$sth->execute();
				if( $sth->execute() )
				{
					$nv_Cache->delMod( $module_name );
					return 'OK_' . $lang_module['report_thanks'] . '_' . $id . '_' . $check_session;
				}
			}
			return 'OK_' . $lang_module['report_thanks'];
		}else{
			if( $check_session == md5( $id . session_id() . $global_config['sitekey'] ) ){
				$stmt = $db->prepare('INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_rows_report VALUES(
				:rid,
				:id)'
				);
				$stmt->bindParam(':id', intval( $id ), PDO::PARAM_STR);
				$stmt->bindParam(':rid', intval( $rid ), PDO::PARAM_STR);
				if( $stmt->execute() )
				{
					$nv_Cache->delMod( $module_name );
					return 'OK_' . $lang_module['report_thanks'] . '_' . $id . '_' . $check_session;
				}
			}
		}
	}else{
		return 'OK_' . $lang_module['error_wrongid'];
	}
}
