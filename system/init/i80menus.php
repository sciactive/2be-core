<?php
/**
 * Process the menus.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (!$_->page->override) {
	if (P_SCRIPT_TIMING) pines_print_time('Process Menus');
	if (P_SCRIPT_TIMING) pines_print_time('Load Menus');
	// Add the system menu.
	$_->menu->add_json_file('system/menu.json');
	// Get the component menus.
	$_p_commenus = glob('components/com_*/menu.json');
	foreach ($_p_commenus as $_p_cur_commenus)
		$_->menu->add_json_file($_p_cur_commenus);
	unset ($_p_commenus, $_p_cur_commenus);
	if (P_SCRIPT_TIMING) pines_print_time('Load Menus');
	if (P_SCRIPT_TIMING) pines_print_time('Render Menus');
	// Create and attach them.
	$_->menu->render();
	if (P_SCRIPT_TIMING) pines_print_time('Render Menus');
	if (P_SCRIPT_TIMING) pines_print_time('Process Menus');
}