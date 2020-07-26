<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Wed, 25 May 2016 06:06:41 GMT
 */

if ( ! defined( 'NV_MAINFILE' ) )
{
	die( 'Stop!!!' );
}

$db_config['dbhost'] = 'localhost';
$db_config['dbport'] = '80';
$db_config['dbname'] = 'lythaito';
$db_config['dbsystem'] = 'lythaito';
$db_config['dbuname'] = 'lythaito';
$db_config['dbpass'] = '343Ol2Jeh15u';
$db_config['dbtype'] = 'mysql';
$db_config['collation'] = 'utf8_general_ci';
$db_config['charset'] = 'utf8';
$db_config['persistent'] = false;
$db_config['prefix'] = 'nv4';

$global_config['site_domain'] = 'thptlythaito.edu.vn,localhost';
$global_config['name_show'] = 0;
$global_config['idsite'] = 0;
$global_config['sitekey'] = 'fff61a4b3ebdffa7d40d6383b4369cca';// Do not change sitekey!
$global_config['hashprefix'] = '{SSHA}';
$global_config['cached'] = 'files';
$global_config['extension_setup'] = 3; // 0: No, 1: Upload, 2: NukeViet Store, 3: Upload + NukeViet Store