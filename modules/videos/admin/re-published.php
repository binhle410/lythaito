<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

if( $nv_Request->isset_request( 'checkss', 'get' ) and $nv_Request->get_string( 'checkss', 'get' ) == md5( $global_config['sitekey'] . session_id() ) )
{
	$listid = $nv_Request->get_string( 'listid', 'get' );
	$id_array = array_map( 'intval', explode( ',', $listid ) );

	$publ_array = array();

	$sql = 'SELECT id, listcatid, status, publtime, exptime FROM ' . NV_PREFIXLANG . '_' . $module_data . '_rows WHERE id in (' . implode( ',', $id_array ) . ')';
	$result = $db->query( $sql );
	while( list( $id, $listcatid, $status, $publtime, $exptime ) = $result->fetch( 3 ) )
	{
		$arr_catid = explode( ',', $listcatid );

		$check_permission = false;
		if( defined( 'NV_IS_ADMIN_MODULE' ) )
		{
			$check_permission = true;
		}
		else
		{
			$check_edit = 0;
			foreach( $arr_catid as $catid_i )
			{
				if( isset( $array_cat_admin[$admin_id][$catid_i] ) )
				{
					if( $array_cat_admin[$admin_id][$catid_i]['admin'] == 1 )
					{
						++$check_edit;
					}
				}
			}
			if( $check_edit == sizeof( $arr_catid ) )
			{
				$check_permission = true;
			}
		}

		if( $check_permission > 0 )
		{
			$data_save = array();
			if( $exptime > 0 and $exptime < NV_CURRENTTIME )
			{
				$data_save['exptime'] = 0;
			}
			$data_save['publtime'] = NV_CURRENTTIME;
			if( $status != 1 )
			{
				$data_save['status'] = 1;
			}

			if( ! empty( $data_save ) )
			{
				$s_ud = '';
				foreach( $data_save as $key => $value )
				{
					$s_ud .= $key . " = '" . $value . "', ";
				}
				$s_ud .= "edittime = '" . NV_CURRENTTIME . "'";
				$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_rows SET ' . $s_ud . ' WHERE id =' . $id );
				foreach( $arr_catid as $catid_i )
				{
					$db->query( 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . '_' . $catid_i . ' SET ' . $s_ud . ' WHERE id =' . $id );
				}
				$publ_array[] = $id;
			}
		}
	}
	if( ! empty( $publ_array ) )
	{
		nv_insert_logs( NV_LANG_DATA, $module_name, 'log_re_publ_content', 'listid: ' . implode( ', ', $publ_array ), $admin_info['userid'] );
	}
	nv_set_status_module();
}

Header( 'Location: ' . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name );
die();

?>