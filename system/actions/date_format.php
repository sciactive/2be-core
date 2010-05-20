<?php
/**
 * Export a formatted date.
 *
 * @package Pines
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hunter@sciactive.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
defined('P_RUN') or die('Direct access prohibited');

if (!gatekeeper())
	punt_user('You don\'t have necessary permission.');

$pines->page->override = true;
$pines->page->override_doc(format_date(!is_numeric($_REQUEST['timestamp']) ? time() : (int) $_REQUEST['timestamp'], empty($_REQUEST['type']) ? 'full_sort' : $_REQUEST['type'], empty($_REQUEST['format']) ? '' : $_REQUEST['format'],  empty($_REQUEST['timezone']) ? null : new DateTimeZone($_REQUEST['timezone'])));

?>