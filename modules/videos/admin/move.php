<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( !defined( 'NV_IS_FILE_ADMIN' ) )
	die( 'Stop!!!' );

$page_title = $lang_module['move'];

$id_array = array();
$listid = $nv_Request->get_string( 'listid', 'get,post', '' );
$catids = array_unique( $nv_Request->get_typed_array( 'catids', 'post', 'int', array() ) );
$catid = $nv_Request->get_int( 'catid', 'get,post', 0 );

if( $nv_Request->isset_request( 'idcheck', 'post' ) )
{
	$id_array = array_unique( $nv_Request->get_typed_array( 'idcheck', 'post', 'int', array() ) );
	if( !empty( $id_array ) AND !empty( $catids ) )
	{
		$listcatid = implode( ',', $catids );
		if( empty( $catid ) )
		{
			$catid = $catids[0];
		}

		$result = $db->query( 'SELECT id, listcatid FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id IN (' . implode( ',', $id_array ) . ')' );
		while( list( $id, $listcatid_old ) = $result->fetch( 3 ) )
		{
			$array_catid_old = explode( ',', $listcatid_old );
			foreach( $array_catid_old as $catid_i )
			{
				$db->exec( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' WHERE id=' . $id );
			}

			$db->exec( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET catid=' . $catid . ', listcatid=' . $db->quote( $listcatid ) . ' WHERE id=' . $id );

			foreach( $catids as $catid_i )
			{
				try
				{
					$db->exec( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id );
				}
				catch( PDOException $e )
				{
					$db->exec( 'DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' WHERE id=' . $id );
					$db->exec( 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id=' . $id );
				}
			}
		}

		$nv_Cache->delMod( $module_name );
		Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
		die();
	}
}
else
{
	$id_array = array_map( 'intval', explode( ',', $listid ) );
}

if( empty( $id_array ) )
{
	Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
	die();
}

$db->sqlreset()->select( 'id, title' )->from( NV_PREFIXLANG . '_' . $module_data . '_rows' )->where( 'id IN (' . implode( ',', $id_array ) . ')' )->order( 'id DESC' );
$result = $db->query( $db->sql() );

$xtpl = new XTemplate( $op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file );
$xtpl->assign( 'LANG', $lang_module );
$xtpl->assign( 'NV_BASE_ADMINURL', NV_BASE_ADMINURL );
$xtpl->assign( 'NV_NAME_VARIABLE', NV_NAME_VARIABLE );
$xtpl->assign( 'MODULE_NAME', $module_name );
$xtpl->assign( 'OP', $op );

while( list( $id, $title ) = $result->fetch( 3 ) )
{
	$xtpl->assign( 'ROW', array(
		'id' => $id,
		'title' => $title,
		'checked' => in_array( $id, $id_array ) ? ' checked="checked"' : ''
	) );

	$xtpl->parse( 'main.loop' );
}

foreach( $global_array_cat as $catid_i => $array_value )
{
	$space = intval( $array_value['lev'] ) * 30;
	$catiddisplay = (sizeof( $catids ) > 1 and ( in_array( $catid_i, $catids ))) ? '' : ' display: none;';
	$temp = array(
		'catid' => $catid_i,
		'space' => $space,
		'title' => $array_value['title'],
		'checked' => ( in_array( $catid_i, $catids )) ? ' checked="checked"' : '',
		'catidchecked' => ($catid_i == $catid) ? ' checked="checked"' : '',
		'catiddisplay' => $catiddisplay
	);
	$xtpl->assign( 'CATS', $temp );
	$xtpl->parse( 'main.catid' );
}

$xtpl->parse( 'main' );
$contents = $xtpl->text( 'main' );

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme( $contents );
include NV_ROOTDIR . '/includes/footer.php';
