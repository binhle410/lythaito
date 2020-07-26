<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_FILE_ADMIN' ) ) die( 'Stop!!!' );

$q = $nv_Request->get_title( 'term', 'get', '', 1 );
if( empty( $q ) ) return;

$db->sqlreset()
	->select('keywords')
	->from( NV_PREFIXLANG . '_' . $module_data . '_tags')
	->where( 'alias LIKE :alias OR keywords LIKE :keywords' )
	->order( 'alias ASC' )
	->limit( 50 );

$sth = $db->prepare( $db->sql() );
$sth->bindValue( ':alias','%' . $q . '%', PDO::PARAM_STR );
$sth->bindValue( ':keywords','%' . $q . '%', PDO::PARAM_STR );
$sth->execute();

$array_data = array();
while( list( $keywords ) = $sth->fetch( 3 ) )
{
	$keywords = explode( ',', $keywords );
	foreach ( $keywords as $_keyword )
	{
		$array_data[] = str_replace('-', ' ', $_keyword) ;
	}
}

header( 'Cache-Control: no-cache, must-revalidate' );
header( 'Content-type: application/json' );

ob_start( 'ob_gzhandler' );
echo json_encode( $array_data );
exit();