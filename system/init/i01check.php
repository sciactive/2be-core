<?php
/**
 * Perform a quick check for system requirements.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) pines_print_time('System Quick Check');

if (!function_exists('json_decode'))
	die('2be requires the PHP JSON extension. Please install it before proceeding.');

if (P_SCRIPT_TIMING) pines_print_time('System Quick Check');