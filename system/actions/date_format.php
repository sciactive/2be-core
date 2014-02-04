<?php
/**
 * Export a formatted date.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (!gatekeeper())
	punt_user();

$_->page->override = true;
header('Content-Type: text/plain');
$_->page->override_doc(format_date(!is_numeric(idx($_REQUEST, 'timestamp')) ? time() : (int) idx($_REQUEST, 'timestamp'), empty(idx($_REQUEST, 'type')) ? 'full_sort' : idx($_REQUEST, 'type'), empty(idx($_REQUEST, 'format')) ? '' : idx($_REQUEST, 'format'), empty(idx($_REQUEST, 'timezone')) ? null : new DateTimeZone(idx($_REQUEST, 'timezone'))));