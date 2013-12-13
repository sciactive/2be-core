<?php
/**
 * The controller for WonderPHP's architecture.
 *
 * WonderPHP - an Enterprise PHP Application Framework
 * Copyright (C) 2008-2013  SciActive.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Hunter can be contacted at hperrin@gmail.com
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */

/*
 * Constants
 */
/**
 * The microtime when the script started executing.
 * @package Core
 */
define('P_EXEC_TIME', microtime(true));
/**
 * Declare that the program is running through the index, as it should.
 * @package Core
 */
define('P_RUN', true);
/**
 * The installation's base path.
 * @package Core
 */
define('P_BASE_PATH', dirname(__FILE__).'/');
/**
 * The name of our index file.
 * @package Core
 */
define('P_INDEX', basename($_SERVER['SCRIPT_FILENAME']));
/**
 * When this is set to true, the times between script stages will be displayed.
 * 
 * Use a JavaScript console (like Firebug) to view the times.
 * @package Core
 */
define('P_SCRIPT_TIMING', false);

// Run the system init scripts.
foreach (glob('system/init/i*.php') as $_p_cur_sysinit) {
	require($_p_cur_sysinit);
}