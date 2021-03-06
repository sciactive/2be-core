<?php
/**
 * Export a CSV document.
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

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.idx($_REQUEST, 'filename').'.csv"');
header('Content-Length: '.strlen(idx($_REQUEST, 'content')));

$_->page->override = true;
$_->page->override_doc(idx($_REQUEST, 'content'));
