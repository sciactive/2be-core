<?php
/**
 * Load the system classes and objects.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

// Strip magic quotes.
if (get_magic_quotes_gpc()) {
	if (P_SCRIPT_TIMING) pines_print_time('Strip Request Slashes');
	pines_stripslashes_array_recursive($_GET);
	pines_stripslashes_array_recursive($_POST);
	pines_stripslashes_array_recursive($_REQUEST);
	pines_stripslashes_array_recursive($_COOKIE);
	if (P_SCRIPT_TIMING) pines_print_time('Strip Request Slashes');
}

if (P_SCRIPT_TIMING) pines_print_time('Load System Classes');
/**
 * Exception Classes
 */
include('system/classes/exceptions.php');
/**
 * Component Class
 */
include('system/classes/component.php');
/**
 * Config Class
 */
include('system/classes/config.php');
/**
 * Core Class
 */
include('system/classes/core.php');
/**
 * Depend Class
 */
include('system/classes/depend.php');
/**
 * Hook Class
 */
include('system/classes/hook.php');
/**
 * Hook Override Class
 */
include('system/classes/hook_override.php');
/**
 * Info Class
 */
include('system/classes/info.php');
/**
 * Menu Class
 */
include('system/classes/menu.php');
/**
 * Module Class
 */
include('system/classes/module.php');
/**
 * Page Class
 */
include('system/classes/page.php');
/**
 * Template Class
 */
include('system/classes/template.php');
if (P_SCRIPT_TIMING) pines_print_time('Load System Classes');

if (P_SCRIPT_TIMING) pines_print_time('Load WonderPHP');
/**
 * The main object for WonderPHP.
 *
 * This object is used to hold everything from WonderPHP's settings, to component
 * functions. Components' configuration files will be parsed into $_->config
 * under the name of their component. Such as $_->config->com_xmlparser.
 * Components' classes will be automatically loaded into $_ under their name
 * when the variable is *first used*. For example, com_xmlparser will be loaded
 * the first time $_->com_xmlparser is accessed.
 *
 * $_ also holds WonderPHP's standard classes/objects (called "services"), which
 * include:
 *
 * WonderPHP Core:
 *
 * - info - System and component info.
 * - config - System and component configuration.
 * - hook - Hook system.
 * - depend - Dependency system.
 * - menu - Menu system.
 * - page - Display controller.
 *
 * Provided by Components:
 *
 * - template - The current template's object.
 * - configurator - Manages configuration settings for WonderPHP and components.
 * - log_manager - Manages logging features.
 * - entity_manager - Manages data abstraction (entities).
 * - user_manager - Manages users, groups, and their permissions.
 * - editor - Provides a content editor.
 * - uploader - Provides a file uploader.
 * - icons - Provides an icon theme.
 *
 * When you want to set your component as one of these services (excluding the
 * core services), place a string with the name of your component's class into
 * the appropriate variable.
 *
 * For example, if you are designing a log manager called com_emaillogs, use
 * this in an init file (like i10set.php):
 *
 * <code>
 * $_->log_manager = 'com_emaillogs';
 * </code>
 *
 * @global core $_
 */
$_ = new core;
if (P_SCRIPT_TIMING) pines_print_time('Load WonderPHP');