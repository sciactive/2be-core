<?php
/**
 * Run the action.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) pines_print_time('Run Requested Action');
// Call the action specified.
if (!$_p_error_module) {
	try {
		if ($_->action($_->request_component, $_->request_action) === 'error_404')
			throw new HttpClientException(null, 404);
	} catch (HttpClientException $e) {
		$_p_error_module = new module('system', 'error', 'content');
		$_p_error_module->exception = $e;
	} catch (HttpServerException $e) {
		$_p_error_module = new module('system', 'error', 'content');
		$_p_error_module->exception = $e;
	}
}
if (P_SCRIPT_TIMING) pines_print_time('Run Requested Action');