<?php
/**
 * Perform a quick check for system requirements.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hunter@sciactive.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $pines pines */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) pines_print_time('System Quick Check');

if (!function_exists('json_decode'))
	die('WonderPHP requires the PHP JSON extension. Please install it before proceeding.');

if (P_SCRIPT_TIMING) pines_print_time('System Quick Check');