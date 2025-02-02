<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

 if( ! defined( 'NV_SYSTEM' ) ) die( 'Stop!!!' );
if( ! in_array( $op, array( 'viewcat', 'detail' ) ) )
{
	define( 'NV_IS_MOD_VIDEOS', true );
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';

global $global_array_cat;
$global_array_cat = array();
$link_i = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=Other';
$global_array_cat[0] = array(
	'catid' => 0,
	'parentid' => 0,
	'title' => 'Other',
	'titlesite' => '',
	'alias' => 'Other',
	'link' => $link_i,
	'viewcat' => 'viewcat_page_new',
	'viewdescription' => '',
	'subcatid' => 0,
	'numlinks' => 3,
	'description' => '',
	'inhome' => 0,
	'keywords' => ''
);
$catid = 0;
$parentid = 0;
$alias_cat_url = isset( $array_op[0] ) ? $array_op[0] : '';
$array_mod_title = array();

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat ORDER BY sort ASC';
$list = $nv_Cache->db( $sql, 'catid', $module_name );
foreach( $list as $l )
{
	$global_array_cat[$l['catid']] = $l;
	$global_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
	if( $alias_cat_url == $l['alias'] )
	{
		$catid = $l['catid'];
		$parentid = $l['parentid'];
	}
}
unset( $sql, $list );

$global_array_block = array();
$sql = 'SELECT bid, title, alias FROM ' . NV_PREFIXLANG . '_' . $module_data . '_block_cat ORDER BY alias ASC';
$list = $nv_Cache->db( $sql, 'bid', $module_name );
foreach( $list as $l )
{
	$global_array_block[$l['bid']] = $l;
	$global_array_block[$l['bid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['groups'] . '/' . $l['alias'];

}

unset( $sql, $list );

$global_array_uploader = array();
$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_uploaders ORDER BY userid ASC';
$list = $nv_Cache->db( $sql, 'userid', $module_name );
foreach( $list as $l )
{
	$global_array_uploader[$l['userid']] = $l;
	$global_array_uploader[$l['userid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['uploader'] . '/' . $l['username'];
	$global_array_uploader[$l['userid']]['uploader_name'] = nv_show_name_user( $l['first_name'], $l['last_name'], $l['username'] );
	$global_array_uploader[$l['userid']]['uploader_list'] = $global_array_uploader[$l['userid']]['link'] . '/list';
	$global_array_uploader[$l['userid']]['uploader_editinfo'] = $global_array_uploader[$l['userid']]['link'] . '/editinfo';
	$global_array_uploader[$l['userid']]['uploader_gravatar'] = get_gravatar($global_array_uploader[$l['userid']]['email']);
}
unset( $sql, $list );

//Xac dinh RSS
if( $module_info['rss'] )
{
	$rss[] = array(
		'title' => $module_info['custom_title'],
		'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss']
	);
}

foreach( $global_array_cat as $catid_i => $array_cat_i )
{
	if( $catid_i > 0 and $array_cat_i['parentid'] == 0 )
	{
		$act = 0;
		$submenu = array();
		if( $catid_i == $catid or $catid_i == $parentid )
		{
			$act = 1;
			if( ! empty( $global_array_cat[$catid_i]['subcatid'] ) )
			{
				$array_catid = explode( ',', $global_array_cat[$catid_i]['subcatid'] );
				foreach( $array_catid as $sub_catid_i )
				{
					$array_sub_cat_i = $global_array_cat[$sub_catid_i];
					$sub_act = 0;
					if( $sub_catid_i == $catid )
					{
						$sub_act = 1;
					}
					$submenu[] = array( $array_sub_cat_i['title'], $array_sub_cat_i['link'], $sub_act );
				}
			}
		}
		$nv_vertical_menu[] = array( $array_cat_i['title'], $array_cat_i['link'], $act, 'submenu' => $submenu );
	}

	//Xac dinh RSS
	if( $catid_i and $module_info['rss'] )
	{
		$rss[] = array(
			'title' => $module_info['custom_title'] . ' - ' . $array_cat_i['title'],
			'src' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_info['alias']['rss'] . '/' . $array_cat_i['alias']
		);
	}
}
unset( $result, $catid_i, $parentid_i, $title_i, $alias_i );

$module_info['submenu'] = 0;

$page = 1;
$per_page = $module_config[$module_name]['per_page'];
$st_links = $module_config[$module_name]['st_links'];
$count_op = sizeof( $array_op );
if( ! empty( $array_op ) and $op == 'main' )
{
	if( $catid == 0 )
	{
		$contents = $lang_module['nocatpage'] . $array_op[0];
		if( isset( $array_op[0] ) and substr( $array_op[0], 0, 5 ) == 'page-' )
		{
			$page = intval( substr( $array_op[0], 5 ) );
		}
		elseif( ! empty( $alias_cat_url ) )
		{
			$redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite( NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true ) . '" />';
			nv_info_die( $lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect );
		}
	}
	else
	{
		$op = 'main';
		if( $count_op == 1 or substr( $array_op[1], 0, 5 ) == 'page-' )
		{
			$op = 'viewcat';
			if( $count_op > 1 )
			{
				$page = intval( substr( $array_op[1], 5 ) );
			}
		}
		elseif( $count_op == 2 )
		{
			$array_page = explode( '-', $array_op[1] );
			$id = intval( end( $array_page ) );
			$number = strlen( $id ) + 1;
			$alias_url = substr( $array_op[1], 0, -$number );
			if( $id > 0 and $alias_url != '' )
			{
				$op = 'detail';
			}
		}
		$parentid = $catid;
		while( $parentid > 0 )
		{
			$array_cat_i = $global_array_cat[$parentid];
			$array_mod_title[] = array(
				'catid' => $parentid,
				'title' => $array_cat_i['title'],
				'link' => $array_cat_i['link']
			);
			$parentid = $array_cat_i['parentid'];
		}
		sort( $array_mod_title, SORT_NUMERIC );
	}
}