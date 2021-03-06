<?php
/**
 * Kill the components.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) pines_print_time('Kill Components');
// Run the component kill scripts.
$_p_comkill = glob('components/com_*/init/k*.php');
// Sort by just the filename.
usort($_p_comkill, 'pines_sort_by_filename');
foreach ($_p_comkill as $_p_cur_comkill) {
	if (P_SCRIPT_TIMING) pines_print_time("Kill Script: $_p_cur_comkill");
	try {
		/**
		 * Include each component kill script in the correct order.
		 */
		include($_p_cur_comkill);
	} catch (HttpClientException $e) {
		$_p_error_module = new module('system', 'error', 'content');
		$_p_error_module->exception = $e;
	} catch (HttpServerException $e) {
		$_p_error_module = new module('system', 'error', 'content');
		$_p_error_module->exception = $e;
	}
	if (P_SCRIPT_TIMING) pines_print_time("Kill Script: $_p_cur_comkill");
}
unset ($_p_comkill, $_p_cur_comkill);
if (P_SCRIPT_TIMING) pines_print_time('Kill Components');