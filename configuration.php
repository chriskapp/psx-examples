<?php
/*
 *  $Id: configuration.php 270 2011-04-16 19:30:28Z k42b3.x $
 *
 * psx
 * A object oriented and modular based PHP framework for developing
 * dynamic web applications. For the current version and informations
 * visit <http://phpsx.org>
 *
 * Copyright (c) 2011 Christoph Kappestein <k42b3.x@gmail.com>
 *
 * This file is part of psx. psx is free software: you can
 * redistribute it and/or modify it under the terms of the
 * GNU General Public License as published by the Free Software
 * Foundation, either version 3 of the License, or any later version.
 *
 * psx is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with psx. If not, see <http://www.gnu.org/licenses/>.
 */

$config = array(

	'tbl_example'             => 'psx_example',

	'psx_url'                 => 'http://example.phpsx.org',
	'psx_dispatch'            => 'index.php/',
	'psx_timezone'            => 'UTC',
	'psx_gzip'                => false,
	'psx_debug'               => true,

	'psx_sql_host'            => 'localhost',
	'psx_sql_user'            => 'root',
	'psx_sql_pw'              => '',
	'psx_sql_db'              => 'psx',

	'psx_routing'             => '../routes',
	'psx_error_template'      => null,
	'psx_path_cache'          => '../cache',
	'psx_path_library'        => '../library',

);


