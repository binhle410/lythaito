<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_MAINFILE' ) )	die( 'Stop!!!' );

$sql = 'SELECT listcatid FROM ' . NV_PREFIXLANG . '_' . $mod_info['module_data'] . '_rows WHERE id=' . $row['id'];
list( $listcatid ) = $db->query( $sql )->fetch( 3 );

// Cap nhat lai so luong comment duoc kich hoat
$array_catid = explode( ',', $listcatid );
$numf = $db->query( 'SELECT COUNT(*) FROM ' . NV_PREFIXLANG . '_comment where module= ' . $db->quote( $row['module'] ) . ' AND id= ' . $row['id'] . ' AND status=1' )->fetchColumn();

$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $mod_info['module_data'] . '_rows SET hitscm=' . $numf . ' WHERE id=' . $row['id'];
$db->query( $query );
foreach( $array_catid as $catid_i )
{
	$query = 'UPDATE ' . NV_PREFIXLANG . '_' . $mod_info['module_data'] . '_' . $catid_i . ' SET hitscm=' . $numf . ' WHERE id=' . $row['id'];
	$db->query( $query );
}
// Het Cap nhat lai so luong comment duoc kich hoat