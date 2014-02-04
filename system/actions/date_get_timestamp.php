<?php
/**
 * Parse a time expression into a timestamp and export it.
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

try {
	if (empty(idx($_REQUEST, 'timezone'))) {
		$date = new DateTime(idx($_REQUEST, 'date'));
	} else {
		$date = new DateTime(idx($_REQUEST, 'date'), new DateTimeZone(idx($_REQUEST, 'timezone')));
	}
	$_->page->override_doc($date->format('U'));
} catch (Exception $e) {
	$_->page->override_doc('error');
}