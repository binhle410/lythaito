<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Oct 08, 2015 10:47:41 AM
 */

if( ! defined( 'NV_IS_MOD_SEARCH' ) ) die( 'Stop!!!' );

$db->sqlreset()
	->select( 'COUNT(*)' )
	->from( NV_PREFIXLANG . '_' . $m_values['module_data'] . '_rows r')
	->join( 'INNER JOIN ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_detail c ON (r.id=c.id)' )
	->where('(' . nv_like_logic( 'r.title', $dbkeywordhtml, $logic ) . ' OR ' . nv_like_logic( 'r.hometext', $dbkeyword, $logic ) . ' OR ' . nv_like_logic( 'c.bodyhtml', $dbkeyword, $logic ) . ')	AND r.status= 1' );

$num_items = $db->query( $db->sql() )->fetchColumn();

if( $num_items )
{
	$array_cat_alias = array();
	$array_cat_alias[0] = 'other';

	$sql_cat = 'SELECT catid, alias FROM ' . NV_PREFIXLANG . '_' . $m_values['module_data'] . '_cat';
	$re_cat = $db->query( $sql_cat );
	while( list( $catid, $alias ) = $re_cat->fetch( 3 ) )
	{
		$array_cat_alias[$catid] = $alias;
	}

	$link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $m_values['module_name'] . '&amp;' . NV_OP_VARIABLE . '=';

	$db->select( 'r.id, r.title, r.alias, r.catid, r.hometext, c.bodyhtml' )
		->order( 'publtime DESC' )
		->limit( $limit )
		->offset( ( $page - 1 ) * $limit );
	$result = $db->query( $db->sql() );
	while( list( $id, $tilterow, $alias, $catid, $hometext, $bodyhtml ) = $result->fetch( 3 ) )
	{
		$content = $hometext . $bodyhtml;

		$url = $link . $array_cat_alias[$catid] . '/' . $alias . '-' . $id . $global_config['rewrite_exturl'];

		$result_array[] = array(
			'link' => $url,
			'title' => BoldKeywordInStr( $tilterow, $key, $logic ),
			'content' => BoldKeywordInStr( $content, $key, $logic )
		);
	}
}