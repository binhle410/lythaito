<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */

if( ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

if( ! nv_function_exists( 'videos_thumbs' ) )
{
	function videos_thumbs( $id, $file, $module_upload, $width = 200, $height = 150, $quality = 90 )
	{
		if( $width >= $height ) $rate = $width / $height;
		else  $rate = $height / $width;

		$image = NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/img/' . $file;
 
		if( $file != '' and file_exists( $image ) )
		{
			$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/img/' . $file;
			$imginfo = nv_is_image( $image );

			$basename = $module_upload . '_' . $width . 'x' . $height . '-' . $id . '-' . md5_file( $image ) . '.' . $imginfo['ext'];

			if( file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload. '/thumbs/' . $basename ) )
			{
				$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/thumbs/' . $basename;
			}
			else
			{

				$_image = new NukeViet\Files\Image( $image, NV_MAX_WIDTH, NV_MAX_HEIGHT );

				if( $imginfo['width'] <= $imginfo['height'] )
				{
					$_image->resizeXY( $width, 0 );

				}
				elseif( ( $imginfo['width'] / $imginfo['height'] ) < $rate )
				{
					$_image->resizeXY( $width, 0 );
				}
				elseif( ( $imginfo['width'] / $imginfo['height'] ) >= $rate )
				{
					$_image->resizeXY( 0, $height );
				}

				$_image->cropFromCenter( $width, $height );

				$_image->save( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/thumbs/', $basename, $quality );

				if( file_exists( NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload. '/thumbs/' . $basename ) )
				{
					$imgsource = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload. '/thumbs/' . $basename;
				}
			}
		}
		elseif( nv_is_url( $file ) )
		{
			$imgsource = $file;
		}
		else
		{
			$imgsource = '';
		}
		return $imgsource;
	}
}

if( ! nv_function_exists( 'nv_block_news_cat' ) )
{
	function nv_block_config_news_cat( $module, $data_block, $lang_block )
	{
		global $site_mods, $nv_Cache;

		$html = '<tr>';
		$html .= '<td>' . $lang_block['catid'] . '</td>';
		$sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
		$list = $nv_Cache->db( $sql, '', $module );
		$html .= '<td>';
		foreach( $list as $l )
		{
			$xtitle_i = '';

			if( $l['lev'] > 0 )
			{
				for( $i = 1; $i <= $l['lev']; ++$i )
				{
					$xtitle_i .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			}
			$html .= $xtitle_i . '<label><input type="checkbox" name="config_catid[]" value="' . $l['catid'] . '" ' . ( ( in_array( $l['catid'], $data_block['catid'] ) ) ? ' checked="checked"' : '' ) . '</input>' . $l['title'] . '</label><br />';
		}
		$html .= '</td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['numrow'] . '</td>';
		$html .= '<td><input type="text" class="form-control w200" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></td>';
		$html .= '</tr>';
		$html .= '<tr>';
		$html .= '<td>' . $lang_block['showtooltip'] . '</td>';
		$html .= '<td>';
		$html .= '<input type="checkbox" value="1" name="config_showtooltip" ' . ( $data_block['showtooltip'] == 1 ? 'checked="checked"' : '' ) . ' /><br /><br />';
		$tooltip_position = array( 'top' => $lang_block['tooltip_position_top'], 'bottom' => $lang_block['tooltip_position_bottom'], 'left' => $lang_block['tooltip_position_left'], 'right' => $lang_block['tooltip_position_right'] );
		$html .= '<span class="text-middle pull-left">' . $lang_block['tooltip_position'] . '&nbsp;</span><select name="config_tooltip_position" class="form-control w100 pull-left">';
		foreach( $tooltip_position as $key => $value )
		{
			$html .= '<option value="' . $key . '" ' . ( $data_block['tooltip_position'] == $key ? 'selected="selected"' : '' ) . '>' . $value . '</option>';
		}
		$html .= '</select>';
		$html .= '&nbsp;<span class="text-middle pull-left">' . $lang_block['tooltip_length'] . '&nbsp;</span><input type="text" class="form-control w100 pull-left" name="config_tooltip_length" size="5" value="' . $data_block['tooltip_length'] . '"/>';
		$html .= '</td>';
		$html .= '</tr>';
		return $html;
	}

	function nv_block_config_news_cat_submit( $module, $lang_block )
	{
		global $nv_Request;
		$return = array();
		$return['error'] = array();
		$return['config'] = array();
		$return['config']['catid'] = $nv_Request->get_array( 'config_catid', 'post', array() );
		$return['config']['numrow'] = $nv_Request->get_int( 'config_numrow', 'post', 0 );
		$return['config']['showtooltip'] = $nv_Request->get_int( 'config_showtooltip', 'post', 0 );
		$return['config']['tooltip_position'] = $nv_Request->get_string( 'config_tooltip_position', 'post', 0 );
		$return['config']['tooltip_length'] = $nv_Request->get_string( 'config_tooltip_length', 'post', 0 );
		return $return;
	}

	function nv_block_news_cat( $block_config )
	{
		global $module_array_cat, $module_info, $site_mods, $module_config, $global_config, $db, $nv_Cache;
		$module = $block_config['module'];
		$show_no_image = $module_config[$module]['show_no_image'];
		if(empty($show_no_image))
		{
			$show_no_image = 'themes/default/images/' . $module . '/' . 'video_placeholder.png';
		}
		$blockwidth = $module_config[$module]['blockwidth'];

		if( empty( $block_config['catid'] ) ) return '';

		$catid = implode( ',', $block_config['catid'] );

		$db->sqlreset()
			->select( 'id, catid, title, alias, homeimgfile, homeimgthumb, hometext, publtime' )
			->from( NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_rows' )
			->where( 'status= 1 AND catid IN(' . $catid . ')' )
			->order( 'publtime DESC' )
			->limit( $block_config['numrow'] );
		$list = $nv_Cache->db( $db->sql(), '', $module );

		if( ! empty( $list ) )
		{
			if( file_exists( NV_ROOTDIR . '/themes/' . $global_config['module_theme']  . '/modules/videos/block_news_cat.tpl' ) )
			{
				$block_theme = $global_config['module_theme'] ;
			}
			else
			{
				$block_theme = 'default';
			}

			$xtpl = new XTemplate( 'block_news_cat.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/videos' );
			foreach( $list as $l )
			{
				$l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . '-' . $l['id'] . $global_config['rewrite_exturl'];
				if( $l['homeimgthumb'] == 1 OR $l['homeimgthumb'] == 2 ) //image file
				{
					$l['thumb'] = videos_thumbs($l['id'], $l['homeimgfile'], $module, $module_config[$module]['homewidth'], $module_config[$module]['homeheight'], 90 );
				}
				elseif( $l['homeimgthumb'] == 3 ) //image url
				{
					$l['thumb'] = $l['homeimgfile'];
				}
				elseif( ! empty( $show_no_image ) ) //no image
				{
					$l['thumb'] = NV_BASE_SITEURL . $show_no_image;
				}
				else
				{
					$l['thumb'] = '';
				}

				$l['blockwidth'] = $blockwidth;

				$l['hometext'] = nv_clean60( $l['hometext'], $block_config['tooltip_length'], true );

				if( ! $block_config['showtooltip'] )
				{
					$xtpl->assign( 'TITLE', 'title="' . $l['title'] . '"' );
				}

				$xtpl->assign( 'ROW', $l );
				if( ! empty( $l['thumb'] ) ) $xtpl->parse( 'main.loop.img' );

				if( $block_config['showtooltip'] )
				{
					$xtpl->assign( 'TOOLTIP_POSITION', $block_config['tooltip_position'] );
					$xtpl->parse( 'main.loop.tooltip' );
				}
				$xtpl->parse( 'main.loop' );
			}

			$xtpl->parse( 'main' );
			return $xtpl->text( 'main' );
		}
	}
}
if( defined( 'NV_SYSTEM' ) )
{
	global $site_mods, $module_name, $global_array_cat, $module_array_cat, $nv_Cache;
	$module = $block_config['module'];
	if( isset( $site_mods[$module] ) )
	{
		if( $module == $module_name )
		{
			$module_array_cat = $global_array_cat;
			unset( $module_array_cat[0] );
		}
		else
		{
			$module_array_cat = array();
			$sql = 'SELECT catid, parentid, title, alias, viewcat, subcatid, numlinks, description, inhome, keywords, groups_view FROM ' . NV_PREFIXLANG . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
			$list = $nv_Cache->db( $sql, 'catid', $module );
			foreach( $list as $l )
			{
				$module_array_cat[$l['catid']] = $l;
				$module_array_cat[$l['catid']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
			}
		}
		$content = nv_block_news_cat( $block_config );
	}
}
