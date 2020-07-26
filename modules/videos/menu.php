<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $mod_data . '_cat ORDER BY sort ASC';
$result = $db->query( $sql );
While( $row = $result->fetch() )
{
	$array_item[$row['catid']] = array(
		'parentid' => $row['parentid'],
		'groups_view' => $row['groups_view'],
		'key' => $row['catid'],
		'title' => $row['title'],
		'alias' => $row['alias']
	);
}