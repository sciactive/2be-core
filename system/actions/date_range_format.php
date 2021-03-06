<?php
/**
 * Export a formatted date range.
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
$_->page->ajax(format_date_range(!is_numeric(idx($_REQUEST, 'start_timestamp')) ? time() : (int) idx($_REQUEST, 'start_timestamp'), !is_numeric(idx($_REQUEST, 'end_timestamp')) ? time() : (int) idx($_REQUEST, 'end_timestamp'), empty(idx($_REQUEST, 'format')) ? null : idx($_REQUEST, 'format'), empty(idx($_REQUEST, 'timezone')) ? null : new DateTimeZone(idx($_REQUEST, 'timezone'))), 'text/plain');