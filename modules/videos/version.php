<?php

/**
 * @Project VIDEOS 4.x
 * @Author KENNYNGUYEN (nguyentiendat713@gmail.com)
 * @Website tradacongnghe.com
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 23 May 2016 08:00:00 GMT
 */

if( ! defined( 'NV_ADMIN' ) or ! defined( 'NV_MAINFILE' ) ) die( 'Stop!!!' );

$module_version = array(
	'name' => 'Videos', // Tieu de module
	'modfuncs' => 'main,viewcat,playlists,uploader,player,groups,detail,search,user-playlist,user-video,v_funcs,tag,rss', // Cac function co block
	'change_alias' => 'playlists,groups,uploader,user-playlist,user-video',
	'submenu' => 'user-playlist,user-video,rss,search',
	'is_sysmod' => 0, // 1:0 => Co phai la module he thong hay khong
	'virtual' => 1, // 1:0 => Co cho phep ao hoa module hay khong
	'version' => '0.2.02', // Phien ban cua module
	'date' => 'Mon, 23 May 2016 08:00:00 GMT', // Ngay phat hanh phien ban
	'author' => 'KENNY NGUYEN (nguyentiendat713@gmail.com)', // Tac gia
	'note' => 'Compatible with NukeViet 4 Final', // Ghi chu
	'uploads_dir' => array( $module_upload, $module_upload . '/img', $module_upload . '/vid', $module_upload . '/img/playlists', $module_upload . '/img/groups',$module_upload . '/thumbs'),
	'files_dir' => array( $module_upload . '/img' )
);